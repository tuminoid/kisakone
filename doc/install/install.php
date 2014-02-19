<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * This file performs the basic installation if Kisakone.
 *
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * */

// Some version of PHP 5 complain about lack of time zone data, so if we can
// we'll set it now
if (is_callable('date_default_timezone_set')) {
    date_default_timezone_set("Europe/Helsinki");
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Kisakone Installation</title>
    </head>
    <body>
<?php

stripSlashesIfNecessary();

if (file_exists('../../config.php')) {
    include('../../config.php');
}

if (@$settings['DB_ADDRESS']) {
    echo "Installation appears to have been completed already. You can not
    re-enter this page without removing the configuration file.";
    return;
}

if (count($_POST)) {
        if (DoInstall()) {
        echo "Done.";
        return;
    }
}
form();

function form() {
?>
<form method="POST">
    <h1>Database connection settings</h1>
    <table>
        <tr><td>Hostname</td><td><input type="text" name="db_host"></td></tr>
        <tr><td>Username</td><td><input type="text" name="db_user"></td></tr>
        <tr><td>Password</td><td><input type="password" name="db_pass"></td></tr>
        <tr><td>Database name</td><td><input type="text" name="db_db"></td></tr>
        <tr><td>Table prefix</td><td><input type="text" name="db_prefix"></td></tr>
    </table>

    <h1>Create database</h1>
    <p>Database will be created if not found with the defined prefix.</p>
    <table>
        <tr><td colspan=2"><input type="checkbox" name="db_extralogin" /> Use different login information for creating the database</td></tr>

        <tr><td>Username</td><td><input type="text" name="db_admin_user"></td></tr>
        <tr><td>Password</td><td><input type="password" name="db_admin_pass"></td></tr>

    </table>
    <h1>Initial Admin Account</h1>
    <table>
    <tr><td>Username</td><td><input type="text" name="ad_user"></td></tr>
    <tr><td>Password</td><td><input type="password" name="ad_pass"></td></tr>
    <tr><td>First Name</td><td><input type="text" name="ad_firstname"></td></tr>
    <tr><td>Last Name</td><td><input type="text" name="ad_lastname"></td></tr>
    <tr><td>E-mail</td><td><input type="text" name="ad_email"></td></tr>
    </table>

    <h1>Miscellaneous settings</h1>
    <p><input type="checkbox" name="rewrite"> Use mod_rewrite</p>
    <p>If the web server is not apache with mod_rewrite enabled (or another compatible option), and you've enabled this setting
    all the internal links will fail. If you can and do use this setting, it does allow the system to use prettier urls.
    </p>
    <p>
        <input type="submit" value="Save">
    </p>
</form>
<?php
}
?>
    </body>
</html>

<?php

function DoInstall() {
    echo '<table>';
    test("Database connection");
    $conn = mysql_connect($_POST['db_host'], $_POST['db_user'], $_POST['db_pass']);
    if (!$conn) {
        return failed();
    }
    success();

    test('Accessing database');
    if (!mysql_select_db($_POST['db_db']))
        return failed();
    success();

    if (@$_POST['db_extralogin']) {
        test("Database Admin connection");
        mysql_close($conn);
        $conn = null;
        $conn = mysql_connect($_POST['db_host'], $_POST['db_admin_user'], $_POST['db_admin_pass'], true);
        if (!$conn) {
            return failed();
        }
        success();

        test('Accessing database');
        if (!mysql_select_db($_POST['db_db']))
            return failed();
        success();
    }

    if (@$_POST['ad_user']) {
        test('Admin username');

        if (!preg_match('/[\w\d_]+/', @$_POST['ad_user'])) {
            return failed();
        }
        success();

    }

    test('Config.php writable');
    $fp = @fopen('../../config.php', 'a');
    if (!$fp)
        return failed();
    success();
    fclose($fp);

    echo '</table><p>Starting installation</p>';

    $prefix = @$_POST['db_prefix'];
    $q = "SELECT 1 FROM `{$prefix}RoundResult`";
    if (@mysql_query($q)) {
        echo "Database appears to be present, won't create it.<br />";
    }
    else {
        if (!InstallDB())
            return;
    }

    if (@$_POST['ad_user']) {
        if (!CreateAdmin())
            return;
    }
    else {
        echo "Not creating an admin user, not asked to.<br>";
    }

    SaveSettings();

    return true;
}

function stripSlashesIfNecessary() {
         if (!get_magic_quotes_gpc())
            return;

         // Luckily php doesn't mind having the array values changed while
         // in the foreach loops.
         foreach ($_POST as $k => $v) $_POST[$k] = stripslashes($v);
         foreach ($_GET as $k => $v) $_GET[$k] = stripslashes($v);
         foreach ($_REQUEST as $k => $v) $_REQUEST[$k] = stripslashes($v);
         foreach ($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);

}

function test($n) {
    printf("<tr><td>Testing: %s</td>", $n);
}

function failed() {
    echo '<td style="color: red">Failed!</td></tr></table>';
    return false;
}

function success() {
    echo '<td style="color: green">Success!</td></tr>';
}

function InstallDB() {
    $source = file_get_contents('_install_db.sql');
    $queries = explode(';', $source);
    $prefix = @$_POST['db_prefix'];
    foreach ($queries as $query) {
        if (!trim($query))
            continue;
        if (trim($query) == 'SHOW WARNINGS')
            continue;
        $query = str_replace(':', $prefix, $query);
        if (!mysql_query($query)) {
            echo $query, "<br>";
            echo mysql_error();
            return false;
        }
    }
    return true;
}

function CreateAdmin() {
    $prefix = @$_POST['db_prefix'];
    $query = sprintf("INSERT INTO %sUser (Username, Password, UserEmail, Role, UserFirstname, UserLastname )
        VALUES ('%s', '%s', '%s', 'admin', '%s', '%s')",
        $prefix,
        mysql_real_escape_string($_POST['ad_user']),
        mysql_real_escape_string(md5($_POST['ad_pass'])),
        mysql_real_escape_string($_POST['ad_email']),
        mysql_real_escape_string($_POST['ad_firstname']),
        mysql_real_escape_string($_POST['ad_lastname'])
        );

    if (mysql_query($query)) {
        return true;
    }
    echo mysql_error();
    return false;
}

function SaveSettings() {
    $now = date('Y-m-d H:i:s');
    $dbaddr= str_replace('"', "\\\"", @$_POST['db_host']);
    $dbuser = str_replace('"', "\\\"", @$_POST['db_user']);
    $prefix = str_replace('"', "\\\"", @$_POST['db_prefix']);
    $dbpass= str_replace('"', "\\\"", @$_POST['db_pass']);
    $dbuser = str_replace('"', "\\\"", @$_POST['db_user']);
    $db = str_replace('"', "\\\"", @$_POST['db_db']);
    $rewrite = @$_POST['rewrite'] ? 'true' : 'false';
    $q = "?";
    $settingsFile =
<<<EOF
<{$q}php
/** Kisakone configuration settings
 * Generated automatically on $now
 * The file itself is in the public domain */
global \$settings;
\$settings['DB_ADDRESS'] = '$dbaddr';

\$settings['DB_DB'] = "$db";
\$settings['DB_USERNAME'] = "$dbuser";
\$settings['DB_PASSWORD'] = "$dbpass";
\$settings['DB_PREFIX'] = "$prefix";

\$settings['USE_MOD_REWRITE'] = $rewrite;

include_once('config_site.php');

$q>
EOF;

    $fp = fopen('../../config.php', 'w');
    if (!$fp) {
        return false;
    }
    fwrite($fp, $settingsFile);
    fclose($fp);
    return true;
}
?>
