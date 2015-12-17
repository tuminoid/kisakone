<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Configuration class. Every other configuration is held here,
 * except database related as they're required to connect to db.
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

require_once 'data/db.php';


// Mappings to config_name keys in DB
const ADMIN_EMAIL = 'AdminEmail';

const EMAIL_ENABLED = 'EmailEnabled';
const EMAIL_ADDRESS = 'EmailAddress';
const EMAIL_SENDER = 'EmailSender';
const EMAIL_VERIFICATION = 'EmailVerification';

const LICENSE_ENABLED = 'LicenseEnabled';
const PAYMENT_ENABLED = 'PaymentEnabled';

const SFL_ENABLED = 'SflEnabled';
const SFL_USERNAME = 'SflUsername';
const SFL_PASSWORD = 'SflPassword';

const PDGA_ENABLED = 'PdgaEnabled';
const PDGA_USERNAME = 'PdgaUsername';
const PDGA_PASSWORD = 'PdgaPassword';

const CACHE_ENABLED = 'CacheEnabled';
const CACHE_TYPE = 'CacheType';
const CACHE_NAME = 'CacheName';
const CACHE_HOST = 'CacheHost';
const CACHE_PORT = 'CachePort';

const TRACKJS_ENABLED = 'TrackjsEnabled';
const TRACKJS_TOKEN = 'TrackjsToken';



/**
 * Get available configuration options and their settings.
 * Used to generate the config menu too
 *
 * @return Array of config options, types, values
 */
function GetConfigs()
{
    return array(
        'config_admin' => array(
            array(ADMIN_EMAIL,          'string',   GetConfig(ADMIN_EMAIL)),
        ),

        'config_email' => array(
            array(EMAIL_ENABLED,        'bool',     GetConfig(EMAIL_ENABLED)),
            array(EMAIL_ADDRESS,        'string',   GetConfig(EMAIL_ADDRESS)),
            array(EMAIL_SENDER,         'string',   GetConfig(EMAIL_SENDER)),
            array(EMAIL_VERIFICATION,   'bool',     GetConfig(EMAIL_VERIFICATION))
        ),

        'config_payments' => array(
            array(LICENSE_ENABLED,      'enum',     GetConfig(LICENSE_ENABLED),         array('no', 'sfl')),
            array(PAYMENT_ENABLED,      'bool',     GetConfig(PAYMENT_ENABLED))
        ),

        'config_pdga' => array(
            array(PDGA_ENABLED,         'bool',     GetConfig(PDGA_ENABLED)),
            array(PDGA_USERNAME,        'string',   GetConfig(PDGA_USERNAME)),
            array(PDGA_PASSWORD,        'string',   GetConfig(PDGA_PASSWORD))
        ),

        'config_cache' => array(
            array(CACHE_ENABLED,        'bool',     GetConfig(CACHE_ENABLED)),
            array(CACHE_TYPE,           'enum',     GetConfig(CACHE_TYPE),              array('memcached')),
            array(CACHE_NAME,           'string',   GetConfig(CACHE_NAME)),
            array(CACHE_HOST,           'string',   GetConfig(CACHE_HOST)),
            array(CACHE_PORT,           'int',      GetConfig(CACHE_PORT))
        ),

        'config_trackjs' => array(
            array(TRACKJS_ENABLED,      'bool',     GetConfig(TRACKJS_ENABLED)),
            array(TRACKJS_TOKEN,        'string',   GetConfig(TRACKJS_TOKEN))
        )
    );
}


/**
 * GetConfig gets a key from :Config database
 *
 * @param string $key One of the consts above
 * @return Returns value if key was set
 */
function GetConfig($key)
{
    static $_config;

    if (!$_config)
        $_config = db_one("SELECT * FROM :Config");

    return @$_config[$key];
}


/**
 * SetConfig sets a key in :Config database
 *
 * @param string $key One of the consts above
 * @param mixed $value Value to be set
 * @param string $value_type One of the types recognized by esc_or_null
 */
function SetConfig($key, $value, $value_type = null)
{
    $key = esc_or_null($key, 'key');
    $value = esc_or_null($value, $value_type);

    return db_exec("UPDATE :Config SET $key = $value");
}
