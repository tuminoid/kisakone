<?php

// This is a one time special script that also migrates your config_site.php
// into database

const CONFIG_SITE = '../../../config_site.php';
const CONFIG = '../../../config.php';

require_once(CONFIG);
# require_once __DIR__ . '/../../../data/db.php';


function InitializeDB()
{
    global $settings;
    global $conn;

    if (!$conn)
        $conn = @mysqli_connect($settings['DB_ADDRESS'], $settings['DB_USERNAME'], $settings['DB_PASSWORD'], $settings['DB_DB']);

    if (!$conn) {
        echo "fatal: code:  " . mysqli_connect_errno();
        echo "fatal: error: " . mysqli_connect_error();
        exit(1);
    }
}


function ExecuteQuery($query)
{
    global $settings;
    global $conn;

    if (!trim($query))
        return;
    if (trim($query) == 'SHOW WARNINGS')
        return;

    $prefix = $settings['DB_PREFIX'];
    $query = str_replace(':', $prefix, $query);

    if (!mysqli_query($conn, $query)) {
        echo "fatal: " . mysqli_error($conn);
        echo "$query\n";
        exit(1);
    }
}


function Upgrade()
{
    if (!file_exists('upgrade.sql'))
        die("fatal: Must run upgrade.php within directory containing 'upgrade.sql'");

    $source = file_get_contents('upgrade.sql');
    $queries = explode(';', $source);

    foreach ($queries as $query)
        ExecuteQuery($query);
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
    global $conn;


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
    TrackjsToken = '%s'
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
    $settings['TRACK_JS_TOKEN']
);

    $prefix = $settings['DB_PREFIX'];
    $query = str_replace(':', $prefix, $migrate_sql);
    if (!mysqli_query($conn, $query)) {
        echo "error: $query\n";
        die(mysqli_error($conn) . "\n");
    }


    $config = file_get_contents(CONFIG);
    $config = str_replace("include_once('config_site.php');", "// Migrated to :Config db\n// include_once('config_site.php');\n", $config);

    if ($settings['DB_ERROR_LOGGING'])
        $config .= '$settings[\'DB_ERROR_LOGGING\'] = ' . ($settings['DB_ERROR_LOGGING'] ? "true" : "false") . ";\n";
    if ($settings['DB_ERROR_LOGGING'])
        $config .= '$settings[\'DB_ERROR_DIE\'] = ' . ($settings['DB_ERROR_DIE'] ? "true" : "false") . ";\n";

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
