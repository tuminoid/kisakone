<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015-2016 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * AD editor input handler
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

require_once 'core/ads.php';
require_once 'core/url.php';
require_once 'core/files.php';


/**
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $problems = array();

    $id = @$_GET['id'];
    if ($id == 'default')
        $id = '';

    if (@$_POST['cancel']) {
        if ($id)
            redirect(url_smarty(array('page' => 'eventads', 'id' => @$_GET['id']), $_GET));

        redirect(url_smarty(array('page' => 'ads'), $_GET));
    }

    if (!$id) {
        $id = null;
        if (!isAdmin())
            return Error::AccessDenied();
    }
    else {
        $event = GetEventDetails($id);
        if (!$event)
            return Error::NotFound('event');
        if (!IsAdmin() && $event->management != 'td')
            return Error::AccessDenied();
    }

    $contentid = @$_GET['adType'];

    $ad = GetAd($id, $contentid);
    if (is_a($ad, 'Error'))
        return $ad;
    if (!$ad)
        $ad = InitializeAd($id, $contentid);

    if (is_a($ad, 'Error'))
        return $ad;

    // Sanitize urls
    $url = sanitize_url($_POST['url']);
    $image_url = sanitize_url($_POST['image_url']);

    switch ($_POST['ad_type']) {
        case 'default':
            $ad->MakeDefault();
            break;


        case 'eventdefault':
            $ad->MakeEventDefault();
            break;


        case 'html':
            $ad->MakeHTML($_POST['html']);
            break;


        case 'disabled':
            $ad->MakeDisabled();
            break;


        case 'reference':
            $ad->MakeReference($_POST['ad_ref']);
            break;


        case 'imageandlink':
            switch (@$_POST['image_type']) {
                case 'link':
                    $ad->MakeImageAndLink($url, null, $image_url);
                    break;


                case 'upload':
                    $fid = StoreUploadedImage('ad');
                    if (is_a($fid, 'Error'))
                        return $fid;

                    $ad->MakeImageAndLink($url, $fid, null);
                    break;


                case 'internal':
                    $ad->MakeImageAndLink($url, $_POST['image_ref'], null);
                    break;


                default:
                    echo $_POST['image_type'];
                    die('Error1');
            }

        break;


        default : echo $_POST['ad_type'];
        die('Error');
    }

    if (!@$_POST['preview']) {
        $result = $ad->save();
        if (is_a($result, 'Error'))
            return $result;

        if ($id)
            redirect(url_smarty(array('page' => 'eventads', 'id' => @$_GET['id']), $_GET));

        redirect(url_smarty(array('page' => 'ads'), $_GET));
    }
    else
        return $ad;
}
