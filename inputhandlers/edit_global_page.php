<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Global text page edit handler
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

require_once 'core/textcontent.php';


/**
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    if (!IsAdmin())
        return error::AccessDenied();

    $problems = array();
    $custom = @$_GET['mode'] == 'custom';
    $email = @$_REQUEST['mode'] == 'email';

    if (@$_POST['cancel']) {
        if (!$email)
            redirect(url_smarty(array('page' => 'sitecontent_main'), $custom));
        redirect(url_smarty(array('page' => 'manage_email'), $custom));
    }

    $evp = GetGlobalTextContent(@$_GET['id']);

    if (@$_POST['delete']) {
        if ($evp && $evp->id) {
            $outcome = $evp->Delete();
            if (is_a($outcome, 'Error'))
                return $outcome;
        }

        redirect(url_smarty(array('page' => 'sitecontent_main'), $custom));
    }

    $title = @$_POST['title'];
    $content = @$_POST['textcontent'];

    if ($custom && !$title) {
        $error = new Error();
        $error->title = translate('title_is_mandatory');
        $error->function = 'InputProcessing:edit_event_page:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }
    elseif ($custom && ($title == 'index' || $title == 'submenu' || $title == 'fees' || $title == 'terms'))
        return Error::AccessDenied();

    if (!$evp) {
        $evp = new TextContent(array());
        $evp->event = null;
        $evp->type = (is_numeric(@$_GET['id']) || @$_GET['id'] == '*') ? 'custom' : @$_GET['id'];
    }

    $evp->title = $title ? $title : $evp->type;
    $evp->content = $content;

    if ($custom) {
        $type = @$_POST['type'];

        if ($type == 'custom' || $type == 'custom_man' || $type == 'custom_adm')
            $evp->type = $type;
        else
            return Error::AccessDenied();
    }

    if (!@$_POST['preview'])
        $result = $evp->Save();
    else {
        $evp->FormatText();
        return $evp;
    }

    if (is_a($result, 'Error'))
        return $result;

    if (!$email)
        redirect(url_smarty(array('page' => 'sitecontent_main'), $custom));
    redirect(url_smarty(array('page' => 'manage_email'), $custom));
}
