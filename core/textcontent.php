<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * This file contains the TextContent class. TextContent is used for nearly
 * all user-entered content.
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

class TextContent
{
    // Sometimes title is not used,
    var $title;
    var $event;
    var $id;

    // Type determines what this content is used for, common ones are "news" and "custom".
    var $type;
    var $content;
    var $order;
    var $date;

    var $formattedText;

    function TextContent($row)
    {
        foreach ($row as $key => $value) {
            $varname = strtolower($key);
            $this->$varname = $value;
        }

        if ($this->type == 'submenu' || $this->type == 'index') {
            $this->FormatText(false);
        } else {
            $this->FormatText();
        }

    }

    function Delete()
    {
        DeleteTextContent($this->id);
    }

    /**
     * Some content has default title; this function returns title which is
     * to be shown (content title if defined, default title otherwise)
    */
    function GetProperTitle()
    {
        if ($this->title) return $this->title;
        return translate('pagetitle_' . $this->type);
    }

    function Save()
    {
        SaveTextContent($this);
    }

    /**
     * Prepares the content for use in a page. After call, use the formattedText variable.
     * Not used by email
     */
    function FormatText($disableXHTML = true)
    {
        $this->formattedText = $this->content;

        // can't guarantee that the contained text is valid xhtml
        if ($disableXHTML && trim($this->formattedText) != '') {
            $GLOBALS['disable_xhtml']  = true;
        }
    }

}

/**
 * This function returns global text content based on its content id. If $searchByTitle is
 * set to true, and no content matches the id, $contentId is assumed to be the title
 * of the page and it's searched as such.
 */
function GetGlobalTextContent($contentId, $searchByTitle = false)
    {
        if ( is_numeric( $contentId)) {
            $content = GetTextContent( $contentId);
            if (!$content || $content->event !== null) {
                return Error::accessDenied();
            }
        } else {
            $content = GetTextContentByEvent(null, $contentId);
            if ($searchByTitle && !$content) {
                $content = GetTextContentByTitle(null, $contentId);
            }
        }

        return $content;
    }
