<?php

// This is a one time special script that also migrates your config_site.php
// into database

const CONFIG_SITE = '../../../config_site.php';
const CONFIG = '../../../config.php';

require_once(CONFIG);


function InitializeDatabaseConnection()
{
  $retValue = null;
  global $settings;
  $con = @mysql_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD']);

  if (!($con && @mysql_select_db($settings['DB_DB']))) {
    die("error: Unable to connect to DB...");
  }

  return $retValue;
}


function Upgrade() {
    global $settings;

    if (!file_exists('upgrade.sql'))
        die("error: Please run upgrade.php within directory containing 'upgrade.sql'");

    $source = file_get_contents('upgrade.sql');
    $queries = explode(';', $source);
    $prefix = $settings['DB_PREFIX'];

    foreach ($queries as $query) {
        if (!trim($query))
            continue;
        if (trim($query) == 'SHOW WARNINGS')
            continue;
        $query = str_replace(':', $prefix, $query);
        if (!mysql_query($query)) {
            echo $query, "<br>";
            die(mysql_error() . "\n");
        }
    }

    return true;
}


function MigrateConfigs()
{
    if (file_exists(CONFIG_SITE)) {
        require_once CONFIG_SITE;
    }
    else {
        echo "warning: config_site.php not present, skipping config migration!";
        return;
    }


    global $settings;
    $migrate_sql = sprintf("
UPDATE :Config SET
    AdminEmail = '',

    EmailEnabled = '%d',
    EmailAddress = '%s',
    EmailSender = '%s',

    LicenseEnabled = '%s',

    SflEnabled = '%d',
    SflUsername = '%s',
    SflPassword = '%s',

    PdgaEnabled = '%d',
    PdgaUsername = '%s',
    PdgaPassword = '%s',

    CacheEnabled = '%d',
    CacheType = '%s',
    CacheName = '%s',
    CacheHost = '%s',
    CachePort = '%s',

    TrackjsEnabled = '%d',
    TrackjsToken = '%s',

    Devel_DbLogging = '%d',
    Devel_DbDieOnError = '%d'
;",
    $settings['EMAIL_ENABLED'] == true ? 1 : 0,
    $settings['EMAIL_SENDER'],
    $settings['EMAIL_MAILER'],

    IGNORE_PAYMENTS ? 'no' : ($settings['SFL_ENABLED'] ? 'sfl' : 'internal'),

    $pdga_enabled = $settings['PDGA_ENABLED'] == true ? 1 : 0,
    $settings["PDGA_USERNAME"],
    $settings["PDGA_PASSWORD"],

    $cache_enabled = $settings['MEMCACHED_ENABLED'] == true ? 1 : 0,
    'memcached',
    $settings['MEMCACHED_NAME'],
    $settings['MEMCACHED_HOST'],
    $settings['MEMCACHED_PORT'],

    $settings['TRACK_JS_TOKEN'] != "" ? 1 : 0,
    $settings['TRACK_JS_TOKEN'],

    $devel_db_logging = $settings['DB_ERROR_LOGGING'] == true ? 1 : 0,
    $devel_db_dieonerror = $settings['DB_ERROR_DIE'] == true ? 1 : 0
);

    $prefix = $settings['DB_PREFIX'];
    $query = str_replace(':', $prefix, $migrate_sql);
    if (!mysql_query($query)) {
        echo "error: $query\n";
        die(mysql_error() . "\n");
    }

    $config = file_get_contents(CONFIG);
    if ($config === false) {
        echo "error: failed to read the config.php...";
        return;
    }

    $config = str_replace("include_once('config_site.php');", "// Migrated to :Config db\n// include_once('config_site.php');", $config);
    if (file_put_contents(CONFIG, $config) === false) {
        echo "error: failed to write config into 'config.php'.\n";
        echo "Comment out 'incluce_once('config_site.php');' line and delete 'config_site.php'";
    }
}


InitializeDatabaseConnection();
Upgrade();
MigrateConfigs();
