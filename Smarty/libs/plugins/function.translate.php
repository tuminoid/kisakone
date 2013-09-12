<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {translate} function plugin
 *
 * Type:     function<br>
 * Name:     eval<br>
 * Purpose:  evaluate a template variable as a template<br>
 * @author Tapani Haka
 * @param array
 * @param Smarty
 */
function smarty_function_translate($params, &$smarty)
{
    die();
    $fp = fopen('debug', 'w');
    
    fwrite($fp, print_r($params, true));
    fclose($fp);
}

s
?> 