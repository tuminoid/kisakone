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

require_once 'data/config.php';


/**
 * Connect to memcached
 *
 * @return  memcached object or null on failure or disabled
 */
function cache_connect()
{
    static $_memcached;

    if ($_memcached)
        return $_memcached;

    if (!GetConfig(CACHE_ENABLED))
        return null;

    // connect to memcached pool
    $name = GetConfig(CACHE_NAME);
    $host = GetConfig(CACHE_HOST);
    $port = GetConfig(CACHE_PORT);
    $_memcached = new Memcached($name);
    if (!$_memcached)
        return null;

    $servers = $_memcached->getServerList();
    if (!is_array($servers) || count($servers) < 1)
        $_memcached->addServer($host, $port);

    // check the pool is ok
    $stats = $_memcached->getStats();
    $key = $host . ":" .$port;
    if (!(isset($stats[$key]) && @$stats[$key]['pid'] > 0))
        $_memcached = null;

    return $_memcached;
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
        return false;

    return $cache->set(md5($key), $value, time() + $expires);
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
        return false;

    return $cache->get(md5($key));
}


/**
 * Delete a value in memcached
 *
 * @param string $key key identifier
 * @return  true/false
 */
function cache_del($key)
{
    $cache = cache_connect();
    if (!$cache)
        return false;

    return $cache->delete(md5($key));
}
