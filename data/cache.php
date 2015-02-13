<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Module for handling memcached.
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

require_once 'config.php';


/**
 * Connect to memcached
 *
 * @return  memcached object
 */
function cache_connect()
{
    global $settings;
    static $memcached;

    if (!@$settings['MEMCACHED_ENABLED'])
        return null;

    if ($memcached)
        return $memcached;

    // connect to memcached pool
    $name = $settings['MEMCACHED_NAME'];
    $host = $settings['MEMCACHED_HOST'];
    $port = $settings['MEMCACHED_PORT'];
    $memcached = new Memcached($name);
    $memcached->addServer($host, $port);

    // check the pool is ok
    $stats = $memcached->getStats();
    $key = $host . ":" .$port;
    if (!(isset($stats[$key]) && @$stats[$key]['pid'] > 0))
        $memcached = null;

    return $memcached;
}


/**
 * Save a value to memcached, set to expire at $expires seconds
 *
 * @param string $key key identifier
 * @param mixed $value whatever value
 * @param int $expires seconds until expired
 * @return  true/false
 */
function cache_set($key, $value, $expires = 0)
{
    $cache = cache_connect();
    if (!$cache)
        return null;

    return $cache->set(md5($key), $value, $expires);
}


/**
 * Save a value to memcached, set to expire at $expires seconds
 *
 * @param string $key key identifier
 * @return  true/false
 */
function cache_get($key)
{
    $cache = cache_connect();
    if (!$cache)
        return null;

    return $cache->get(md5($key));
}
