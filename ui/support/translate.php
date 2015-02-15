<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2013-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Language subsystem
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

require_once 'data/cache.php';


/**
 * This class contains the details of a loaded language.
 */
class Language
{
    /**
     * Contains all loaded language data as an associative array. Item key is the
     * text token, the value is the actual string.
     * @access private
     * @var array
    */
    var $data;

    /**
     * For the purposes of determining which language was selected, this variable
     * can be checked.
     * @access public
     * @var string
     */
    var $id;

    /**
     * As a callback is used for replacing inner tokens within a string, data
     * has to be relayed to it somehow. This variable is used for holding the
     * token values for a single translation as an associative array, where the
     * key stands for token id, value is the token value.
     * @access private
     * @var array
     */
    var $tokens;

    var $dir;
    var $allLoaded = false;

    /**
     * Constructor for the class. Loads the specified language.
     * @param string $id Identifier for the language this object is being created for.
    */
    function Language($id)
    {
        // Making sure the id is safe to be used
        $id = basename($id);
        $this->id = $id;
        $this->data = array();

        $langdirname = 'ui/languages/' . $id;
        if (!file_exists($langdirname) || !is_dir($langdirname))
            error('Could not load language');

        $this->dir = $langdirname;
    }

    function LoadAllFiles()
    {
        $this->allLoaded = true;
        $langdirname = $this->dir;
        $id = $this->id;

        $data = cache_get('translate_loadallfiles');
        if ($data) {
            $this->data = $data;
            return;
        }

        $dir = opendir($langdirname);
        if ($dir === false)
            error('Could not load language.');

        while (($filename = readdir($dir)) !== false) {
            if ($filename == '.' || $filename == '..')
                continue;
            $langfilename = 'ui/languages/' . $id . '/' . $filename;

            if (is_dir($langfilename))
                continue;
            $langfile = fopen($langfilename, 'r');

            while (!feof($langfile)) {
                $line = trim(fgets($langfile));

                // Ignoring empty lines and comments
                if ($line == "" || $line[0] == '#')
                    continue;

                $parts = explode(" ", $line, 2);
                if (count($parts) != 2)
                    echo $line;
                $this->data[$parts[0]] = trim($parts[1]);

                // 2-way mapping
                if ($parts[0][0] == ':')
                    $this->data[trim($parts[1])] = trim(substr($parts[0], 1));
            }
            fclose($langfile);
        }
        closedir($dir);

        cache_set('translate_loadallfiles', $this->data, 7 * 24 * 60 * 60);
    }

    function LoadSingleFile($file)
    {
        $file = basename($file);
        $id = $this->id;

        $langfilename = 'ui/languages/' . $id . '/' . $file;
        if (!file_exists($langfilename))
            return false;

        $data = cache_get($langfilename);
        if (!$data) {
            $langfile = fopen($langfilename, 'r');

            while (!feof($langfile)) {
                $line = trim(fgets($langfile));

                // Ignoring empty lines and comments
                if ($line == "" || $line[0] == '#')
                    continue;

                $parts = explode(" ", $line, 2);
                $data[$parts[0]] = trim($parts[1]);
                // 2-way mapping
                if ($parts[0][0] == ':')
                    $data[trim($parts[1])] = trim(substr($parts[0], 1));
            }

            fclose($langfile);

            cache_set($langfilename, $data, 7 * 24 * 60 * 30);
        }
        $this->data = array_merge($this->data, $data);

        return true;
    }

    /**
     * Translates a given token into proper text.
     *
     * Arguments are used for replacing subtokens within the string. For example,
     * the string could be "Hello, {name}!", and if the arguments array is
     * array("name" => "Bob"), the produced string would be "Hello, Bob!".
     *
     * If this function is used from a context where
     * arguments can't be passed, it is possible to append them to the token
     * identifier as follows: token/arg1:value1/arg2:value2...
     * This can not be done when the token value contains a slash.
     *
     * @param string $id        The token to be translated.
     * @param array  $arguments Values for subtokens found within the string.
     */
    function translate($id, $arguments)
    {
        // Extract arguments from the token id if necessary
        if (strpos($id, '/') !== false) {
            $data = $this->ExtractFromID($id);
            $id = $data[0];
            $arguments = $data[1];
        }
        elseif (isset($arguments['arguments']))
            $arguments = $arguments['arguments'];

        if (!array_key_exists($id, $this->data)) {
            if ($this->allLoaded)
                return "[Missing $id]";
            else {
                $this->LoadAllFiles();
                return $this->translate($id, $arguments);
            }
        }

        $str = $this->data[$id];
        $this->tokens = $arguments;

        // This regular expression matches anything contained within curly braces.
        $text = preg_replace_callback('/\{([^}]+)\}/', array($this, 'ReplaceToken'), $str);

        // Convert any HTML entities found -- if necessary
        if (substr($text, 0, 6) == "<HTML>")
            $text = substr($text, 6);
        else
            $text = htmlspecialchars($text);

        // Lastly add forced line changes as necessary
        $text = str_replace("\\n", "<br />", $text);

        return $text;
    }

    /**
     * Callback function for preg_replace_callback, when used for replacing subtokens
     * within a string.
     * @param  array  $token The found match
     * @return string Value for the token
     * @access private
     */
    function replaceToken($token)
    {
        return $this->tokens[$token[1]];
    }

    /**
     * A function used for making sure the language was loaded properly.
     * @return boolean True if the language contains data, false if not.
     */
    function seemsOK()
    {
        return count($this->data) > 0;
    }

    /**
     * This function extracts the id and arguments when they are provided in the
     * same string, in the format id/arg1:value1/arg2:/value2/.../argn:valuen
     * @param  string $id String in the specified format
     * @return array  Array, with first element being the token id, the second element
     *                   is an associative array where keys stand for argument names, values are
     *                   the corresponding values
     * @access private
     */
    function extractFromID($id)
    {
        $parts = explode('/', $id);
        $arguments = array();
        $id = $parts[0];

        // Prevent the id from being used as an argument
        unset($parts[0]);

        foreach ($parts as $part) {
            list($key, $value) = explode(':', $part, 2);
            $arguments[$key] = $value;
        }

        return array($id, $arguments);
    }
}

/**
 * This is a dummy language implementation which simply prints tokens passed
 * to it. Used for error message display whenever no language was successfully loaded.
 *
 * Implements the public interface from Language class. Due to major differences in
 * functionality, the class is not extented.
 */
class DummyLanguage
{
    /**
     * A function used for making sure the language was loaded properly.\
     * @return boolean Always true when this class is used.
     */
    function seemsOK()
    {
        return true;
    }

    /**
     * Function normally used for translating a given text token id, in this
     * case it's merely returned though, within brackets.
     *
     * As function having fewer parameters than a call doesn't matter, the normal
     * $parameter is missing entrirely due to being unnecessary.
     *
     * @param  string $id Id to be translated.
     * @return string $id in brackets
     */
    function Translate($id)
    {
        return "[$id]";
    }
}

/**
 * This function provides slightly simplified interface for translating text. See
 * the specifics of the parameters from Language::translate
 * @param string $id String token id for the desired text
 * @param array $param Values for the subtokens in the string.
 * @see Language::translate
 */
function translate($id, $params = array())
{
    global $language;

    return $language->translate($id, $params);
}

function language_include($file)
{
    global $language;

    return $language->LoadSingleFile($file);
}

/**
 * Loads the provided language.
 * @param string $id Identifier for the language to be loaded.
 */
function LoadLanguage($id, $return = false)
{
    /**
     * @global Language $GLOBALS['language'] Object for the language being used.
    */
    global $language;

    $newlanguage = new Language($id);
    if ($return)
        return $newlanguage;
    $language = $newlanguage;
}
