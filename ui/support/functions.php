<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm§
 *
 * Additional smarty template functions
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

/**
 * This function normally called through smarty returns and URL to specified internal page.
 * A nice-looking url is returned if mod_rewrite can be used, a index.php?page=xxx... url
 * is returned otherwise.
 *
 * @param array $params Contains target page details. Page is used for choosing the subpage, everything else is used as key=value parameters on the url.
 * @param Smarty Reference to smarty object this function is called through.
 * @return string The URL
 *
 * @note If the only entry in $params is 'arguments', that entry is used as $params
 */
function url_smarty($params, &$smarty)
{
    if (count($params) == 1 && array_key_exists('arguments', $params)) $params = $params['arguments'];

    if (@$params['extend_current']) {
        unset($params['extend_current']);
        foreach (@$_GET as $key => $value) {
            if ($key == 'path') continue;
            if (is_array($value)) $value = implode('/', $value);
            if (!isset($params[$key])) $params[$key] = $value;
        }

    }

    global $settings;
    global $language;
    $suffix = '';
    if (@$params['_url_suffix']) {
        $suffix = $params['_url_suffix'];
        unset ($params['_url_suffix']);
    }

    if ($settings['USE_MOD_REWRITE']) {
        $string = baseurl();
        $page = $params['page'];

        if (array_key_exists(":page:" . $page, $language->data)) $page = substr(translate(":page:" . $page), 5);

        $string .= $page;
        unset($params['page']);
        if (count($params) == 0) return $string;

        // If there are any paramaters, id must be present. If it's not on the provided
        // argument list, "default" is used instead.
        if (array_key_exists('id', $params)) {
            $id = $params['id'];
            if (array_key_exists(":id:" . $id, $language->data)) $id = substr(translate(":id:" . $id), 3);

            $string .= '/' . urlencode($id);
            unset($params['id']);
        } else {
            $string .= '/default';
        }

        // Finally, append all named parameters.
        foreach ($params as $key => $value) {
            if ($value === "" || $value === null) continue;

            if (array_key_exists(":$key:" . $value, $language->data)) $value = substr(translate(":$key:" . $value), strlen($key) + 1);
            if (array_key_exists(":param:" . $key, $language->data)) $key = substr(translate(":param:" . $key), 6);


            $string .= '/' . urlencode($key) . '/' . urlencode($value);
        }

        $string .= $suffix;
    } else {

         // No mod_rewrite, simply append all the parameters to the index url.
         $string = "index.php?";
         foreach ($params as $key => $value) {

            $string .= urlencode($key) . '=' . urlencode($value) . '&';
         }

    }

    // When used from within a template (smarty object as 2nd parameter) the
    // html entity conversion is automatic, otherwise the plain URL is returned
    if (is_a($smarty, 'Smarty')) {
        return htmlentities($string);
    } else {
        return $string;
    }
}


/**
 * This function provides an interface through which smarty templates can translate
 * their text content.
 * @param array $params Smarty call arguments. 'id' is used as the text token, and the whole
 *                      array is passed as potential arguments. If 'assign' is present, nothing
 *                      is returned and instead the smarty variable defined is assigned to.
 * @params Smarty $smarty  Reference to the smarty object through which this function was called.
 * @return string|void Normally returns the translated string, however, if parameter 'assign' is defined,
 *                     nothing is returned.
 * @see Language::translate
 */
function translate_smarty($params, &$smarty)
{
    global $language;
    $escape = true;
    if (array_key_exists('escape', $params)) $escape =(bool) $params['escape'];
    $string = $language->Translate($params['id'], $params);

    if (!$escape) $string = html_entity_decode($string);

    if (array_key_exists('assign', $params)) {
        $smarty->assign($params['assign'], $string);
    } else {
        return $string;
    }
}

/**
 * This function generates notification fields for form filling errors
 * @param array $params Smarty call arguments. 'field' is used as reference to the field, other
 * parameters are not used at this time
 * @params Smarty $smarty  Reference to the smarty object through which this function was called.
 * @return string HTML code for the error
 * @see Language::translate
 */
function formerror_smarty($params, &$smarty)
{
    $errors = $smarty->get_template_vars('error');
    $error = @$errors[$params['field']];

    if ($error) {
        return "<div class=\"fielderror\">$error</div>";
    } else {
        return "<div class=\"fielderror\"></div>";
    }


}

function initializeGetFormFields_Smarty($params, &$smarty)
{
    $out = '';

    global $parameterInPath;

    foreach ($_GET as $param => $value) {
        if ($param == 'path') continue;
        if (@$parameterInPath[$param]) continue;
        if (array_key_exists($param, $params) && !$params[$param]) continue;
        if ($param == 'page' && is_array($value)) $value = implode('/', $value);
        $value = htmlentities($value);
        $param = htmlentities($param);

        $out .= "<input type=\"hidden\" name=\"$param\" value=\"$value\" />";
    }

    return $out;
}


/**
 * Smarty function, that can be used for providing a sortable heading field for a table.
 *
 * @param array $params String token for the link text is provided at the key 'id'.
 * @param Smarty $smarty Reference to the smarty object this function was called from.
 */
function sortheading_smarty($params, &$smarty)
{
    static $index = 0;

    $prefix = <<<CODE
    <script type="text/javascript">
//<![CDATA[
$(document).ready(function () {
CODE;

    if ($index == 0) {
        $prefix .= "SortableTable();";
    }

    $prefix .= <<<CODE
        SortField($index, ${params['sortType']}Sort);
    });
    //]]>
</script>
CODE;
    $index ++;
    $data = $_GET;
    if (@$data['id'] === "") unset($data['id']);
    unset($data['path']);
    $data['page'] = implode('/', $data['page']);
    $sort = @$_GET['sort'];
    if ($sort != '') {
        $sort = explode(",", $sort);
    } else {
        $sort = array();
    }
    $id = $params['id'];
    $field = @$params['field'];

    if ($sort[0] == $field) {
        $sort[0] = "-" . $field;
    } else {
        $a = array_search($field, $sort);
        if ($a !== false) unset($sort[$a]);

        $a = array_search("-"  . $field, $sort);
        if ($a !== false) unset($sort[$a]);

        array_unshift($sort, $field);
    }
    $data['sort'] = implode(',', $sort);

    $url = htmlentities(url_smarty($data, $data));

    return "$prefix<a class=\"SortHeading\" href=\"#\">" . translate($params['id']) . "</a>";
}


/**
 * Links to other help files. As the help system is not used at all in the current
 * version, this one is unused as well
 */
function Helplink_Smarty($params, &$smarty)
{
    $helpid = $params['page'];

    if (@$_GET['inline']) {
        $l =sprintf('<a class="helplink" href="%s"><span style="display: none">%s</span>%s</a>',

                        url_smarty(array('page' => 'help', 'id' => $helpid), $helpid),
                        htmlentities($helpid),
                        $params['title']

                      );

    } else {
        $l =sprintf('<a class="helplink" href="%s"><span style="display: none">%s</span>%s</a>',

                        url_smarty(array('extend_current' => true, 'showhelp' => $helpid), $helpid),
                        htmlentities($helpid),
                        $params['title']

                      );
    }

    return $l;
}

/**
 * Provides a list containing links to all submenu items under the selected one
 */
function submenulinks_smarty($params, &$smarty)
{
    $links = page_GetSelectedMenuItem($smarty->get_template_vars('submenu'));

    $out = "<ul>";
    foreach ($links['children'] as $link) {
        //print_r($link);
        $out .= sprintf("<li>
            <a href=\"%s\">%s</a></li>",
            url_smarty($link['link'], $smarty),
            $link['title']);

    }
    $out .= '</ul>';

    return $out;
}
