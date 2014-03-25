<?php

/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file includes the Ad class, and other general support functionality for ads
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

// Space-separated list of ad types. Both event-specific and global ads are listed, in
// their own functions. If colon is present in an ad name, special handling needs to take
// place on the corresponding page.
define('GLOBAL_AD_TYPES', 'default index events:currentYear eventarchive tournaments tournament events:mine events:user users user myinfo editmyinfo changepassword register login recoverpassword recover_password_info refer1 refer2 refer3 refer4 refer5');
define('EVENT_AD_TYPES', 'eventdefault index leaderboard newsarchive competitors schedule course signupinfo payment results liveresults cancelsignup erefer1 erefer2 erefer3');

define('AD_DEFAULT', 'default');
define('AD_EVENT_DEFAULT', 'eventdefault');
define('AD_HTML', 'html');
define('AD_DISABLED', 'disabled');
define('AD_IMAGEANDLINK', 'imageandlink');
define('AD_REFERENCE', 'reference');

define('MAX_AD_RENDER_DEPTH', 0);

class Ad
{
    var $id;
    var $url;
    var $contentId;
    var $imageURL;
    var $longData;
    var $imageReference;
    var $type;
    var $event;

    function Ad($idOrArray, $contentId = null, $event = null, $adType = null, $url = null, $imageUrl = null, $longData = null, $imageReference = null)
    {
        if (is_array($idOrArray)) {
            $this->InitializeFromArray($idOrArray);
        } else {
            $this->id = $idOrArray;
            $this->contentId = $contentId;
            $this->imageUrl = $imageUrl;
            $this->url = $url;
            $this->event = $event;
            $this->longData = $longData;
            $this->imageReference = $imageReference;
            $this->type = $adType;

        }
    }

    /**
     * This set of functions converts an existing ad object into an ad of the
     * type specified by the name. All necessary data is provided in parameters
    */

    function MakeDefault()
    {
        $this->type = AD_DEFAULT;
        $this->url = null;
        $this->imageURL = null;
        $this->longData = null;
        $this->imageReference = null;

    }

    function MakeEventDefault()
    {
        $this->type = AD_EVENT_DEFAULT;
        $this->url = null;
        $this->imageURL = null;
        $this->longData = null;
        $this->imageReference = null;

    }

    function MakeDisabled()
    {
        $this->type = AD_DISABLED;
        $this->url = null;
        $this->imageURL = null;
        $this->longData = null;
        $this->imageReference = null;

    }

    function MakeHTML($html)
    {
        $this->type = AD_HTML;
        $this->url = null;
        $this->imageURL = null;
        $this->longData = $html;
        $this->imageReference = null;

    }

    function MakeReference($to)
    {
        if (strpos(" " . GLOBAL_AD_TYPES . " ", $to) === false) {
            if (substr($to, 2) == "e:" &&
                strpos(" " . EVENT_AD_TYPES . " ", $to) === false) {
                // Todo: should really be an error message instead
                $to = "default";
            }
        }

        $this->type = AD_REFERENCE;
        $this->url = null;
        $this->imageURL =null;
        $this->longData = $to;
        $this->imageReference = null;
    }

    function MakeImageAndLink($url, $imageRef, $imageUrl)
    {
        $this->type = AD_IMAGEANDLINK;
        $this->url = $url;
        $this->longData = null;

        if ($imageRef && $imageUrl) {
            return new Error();
        }

        if ($imageRef) {
            $this->imageReference = $imageRef;
        } else {
            $this->imageURL = $imageUrl;
        }

    }

    function Render()
    {
        // As it is trivially possible to enter an infinite loop with ads
        // referencing each other, we need to ensure this is taken care of
        // in a graceful fashion
        global $ad_render_depth;
        if ($add_render_depth > MAX_AD_RENDER_DEPTH) {
            return translate('too_much_ad_recursion');
        }
        $ad_render_depth++;
        $retVal = call_user_method("Render" . $this->type, $this);

        $ad_render_depth--;

        return $retVal;
    }

    /* Below are functions that render ads of various types */

    function RenderDefault()
    {
        if ($this->contentId == 'default') {
            return '';
        } else {
            $ad = GetAd($this->event, 'default');
            if ($ad === null) {
                return '';
            } if (is_a($ad, 'Error')) {
                return $ad;
            }

            return $ad->Render();
        }
    }

    function RenderEventDefault()
    {
        if ($this->contentId == 'eventdefault') {
            // In this particular case we do something that's not strictly speaking
            // what we were told to do -- if event's default ad is told to render itself,
            // it is replaced by global default ad
            return $this->RenderDefault();
        } else {
            $ad = GetAd($this->event, 'eventdefault');
            if ($ad === null) {
                return $this->RenderDefault();
            } if (is_a($ad, 'Error')) {
                return $ad;
            }

            return $ad->Render();
        }
    }

    function RenderHTML()
    {
        return $this->longData;
    }

    function RenderImageAndLink()
    {
        $url = $this->url;
        if ($this->imageReference) {
            require_once 'core/files.php';
            $file = GetFile($this->imageReference);
            $image = baseurl() . "images/uploaded/" . $file->filename;
        } else {
            $image = $this->imageURL;
        }

        return sprintf('<a target="_blank" href="%s"><img src="%s" /></a>',
                       htmlentities($url),
                       htmlentities($image));
    }

    function RenderReference()
    {
        $ref = $this->longData;

        if (substr($ref, 0, 2) == 'e-') {
            $ref = substr($ref, 2);
            $event = $this->event;
        } else {
            $event= null;
        }

        $ad = GetAd($event, $ref);
        if ($ad) {
            return $ad->Render();
        }

        return '';
    }

    function InitializeFromArray($data)
    {
        foreach ($data as $key => $value) {
            $fieldName = core_ProduceFieldName($key);
            $this->$fieldName = $value;
        }
        $this->url = $data['URL'];
        $this->imageURL = $data['ImageURL'];

    }

    function Save()
    {
        SaveAd($this);
    }
}
