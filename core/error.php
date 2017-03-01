<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file contains the Error class, which is used by all modules
 * for reporting errors.
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
class Error
{
    /**
     * User-friendly very brief title of the error.
     * @var string
     * @access public
     */
    var $title;

    /**
     * User-friendly description of the error. HTML permitted.
     * @var string
     * @access public
     */
    var $description;

    /**
     * The determined cause for the error, or if many, an array of causes. Internal text
     * used for highlighting fields etc.
     * @var string or array, depending on context
     */
    var $cause;

    /**
     * More detailed description of the problem, used for debugging
     * @var string
     * @access public
     */
    var $internalDescription;

    /**
     * The function that triggered the error
     * @var string
     * @access public
     */
    var $function;

    /**
     * If set to true, the error is considered to be a major error with no
     * easy recovery.
     * @var boolean
     * @access public
     */
    var $isMajor;

    /**
     * If not null, the page listed here is used for showing the (minor) error
     * instead of the page defined in the request.
     * @var string
     * @access public
     */
    var $errorPage;

    /**
     * If a HTTP error code is to be used, it is defined here.
     */
    var $errorCode;

    /**
     * Any data related to the error; internal uses
     */
    var $data;

    /**
     * URL to redirect to (kinda invalid use of Error class by redirect)
     */
    var $url;

    /*
     * Trace of function calls, helpful for trying to locate the error in vague cases
    */
    var $backtrace;

    function Error()
    {
        $this->backtrace = debug_backtrace();
    }

    // The functions below create Error objects for specific error types with
    // minimal effort  from the caller. Their use is highly recommended when
    // appropriate.
    public static function InternalError($string = "")
    {
        $e = new Error();
        $e->isMajor = true;
        $e->errorCode = 500;
        $e->title = 'error_internal_error';
        $e->description = translate('error_internal_error') . "<br />.\n" . "$string <br />\n" . "<code>\n" .
            print_r(debug_backtrace(), true) . "\n</code>\n";
        $e->errorPage = 'error';

        return $e;
    }

    public static function NotImplemented()
    {
        $e = new Error();
        $e->isMajor = true;
        $e->errorCode = 500;
        $e->title = 'error_not_implemented';
        $e->description = translate('error_not_implemented_description');
        $e->errorPage = 'error';

        return $e;
    }

    public static function NotFound($resourceType)
    {
        $e = new Error();
        $e->isMajor = true;
        $e->errorCode = 404;
        $e->title = "error_{$resourceType}_not_found";
        $e->description = translate("error_${resourceType}_not_found_description");
        $e->errorPage = 'error';

        return $e;
    }

    public static function AccessDenied()
    {
        $e = new Error();
        $e->isMajor = true;
        $e->errorCode = 403;
        $e->title = 'error_access_denied';
        $e->description = translate('error_access_denied_description');
        $e->errorPage = 'error';

        return $e;
    }

    public static function Query($query, $error = '')
    {
        $e = new Error();
        $e->isMajor = true;
        $e->errorCode = 500;
        $e->internalDescription = "Failed SQL query:\n" . $query . "\n" . $error;
        $e->title = 'error_db_query';
        $e->description = translate('error_db_query_description');
        $e->errorPage = 'error';

        return $e;
    }

    static function LogStacktrace()
    {
        if (extension_loaded('Xdebug')) {
            $cnt = 1;
            foreach (xdebug_get_function_stack() as $line) {
                $out = sprintf("%2d: %s(%s) %s:%d", $cnt++,
                    $line['function'], implode(", ", $line['params']),
                    $line['file'], $line['line']
                );
                error_log($out);
            }
        }
    }

}
