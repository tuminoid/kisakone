<?php

// This is a one time special script that also migrates your config_site.php
// into database

const CONFIG_SITE = '../../../config_site.php';
const CONFIG = '../../../config.php';

require_once(CONFIG);
require_once __DIR__ . '/../../../data/db.php';


function InitializeDB()
{
    global $settings;

    if (!db_connect())
        die("fatal: Cannot connect to DB\n");
}


function Upgrade() {
    global $settings;

    if (!file_exists('upgrade.sql'))
        die("fatal: Must run upgrade.php within directory containing 'upgrade.sql'");

    $source = file_get_contents('upgrade.sql');
    $queries = explode(';', $source);

    mysql_query("SET autocommit=0; START TRANSACTION;");

    foreach ($queries as $query) {
        if (!trim($query))
            continue;
        if (trim($query) == 'SHOW WARNINGS')
            continue;
        $query = format_query($query);
        if (!mysql_query($query)) {
            echo "fatal: $query\n";
            echo "error: " . mysql_error() . "\n";
            mysql_query("ROLLBACK;");
            die();
        }
    }

    mysql_query("COMMIT;");

    return true;
}


function CheckUpgrade()
{
    require_once CONFIG_SITE;

    global $settings;

    if (IGNORE_PAYMENTS == false && $settings['SFL_ENABLED'] !== true) {
        echo "fatal: You don't ignore payments and SFL integration is disabled.\n";
        echo "fatal: Support for managing fees internally in Kisakone has been deprecated and removed.\n";
        echo "fatal: Cannot continue upgrade as you would lose functionality you are currently using.\n";
        exit(1);
    }
}


function MigrateConfigs()
{
    require_once CONFIG_SITE;
    global $settings;


    $migrate_sql = sprintf("
UPDATE :Config SET
    AdminEmail = '%s',

    EmailEnabled = '%d',
    EmailAddress = '%s',
    EmailSender = '%s',
    EmailVerification = '%d',

    LicenseEnabled = '%s',
    PaymentEnabled = '%d',

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
;\n",
    '', // admin email

    $settings['EMAIL_ENABLED'] == true ? 1 : 0,
    $settings['EMAIL_SENDER'],
    $settings['EMAIL_MAILER'],
    0, // email verification

    IGNORE_PAYMENTS !== false ? 'no' : 'sfl',
    IGNORE_PAYMENTS === true ? 0 : 1,

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
    $config = str_replace("include_once('config_site.php');", "// Migrated to :Config db\n// include_once('config_site.php');", $config);
    if (file_put_contents(CONFIG, $config) === false) {
        echo "error: failed to write config into 'config.php'.\n";
        echo "Comment out 'incluce_once('config_site.php');' line and delete 'config_site.php'\n";
        echo "Settings are now available at Admin interface.\n";
    }
}


InitializeDB();
CheckUpgrade();
Upgrade();
MigrateConfigs();
