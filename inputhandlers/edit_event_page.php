<?php
/*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm�
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Event-specific page editing
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
 * Processes the edit tournament form
 * @return Nothing or Error object on error
 */
function processForm()
{
    $event = GetEventDetails(@$_GET['id']);
    if (!$event) return Error::NotFound('event');

    $custom = @$_GET['mode'] == 'custom';
    $news = @$_GET['mode'] == 'news';

    if (@$_POST['cancel']) {

        if ($custom) {
            redirect("Location: " . url_smarty(array('page' => 'editcustomeventpages', 'id' => @$_GET['id']), $custom));
        } elseif ($news) {
            redirect("Location: " . url_smarty(array('page' => 'editnews', 'id' => @$_GET['id']), $custom));
        } else {
            redirect("Location: " . url_smarty(array('page' => 'editeventpages', 'id' => @$_GET['id']), $custom));
        }
        die();
    }

    $evp = $event->GetTextContent(@$_GET['content']);

    if (!IsAdmin() && $event->management != 'td') {
        $denied = true;
        if ($event->management == 'official') {
            if (!$evp && $news) $denied = false;
            else if ($evp->type =='news') $denied = false;
        }

        if ($denied) return Error::AccessDenied('eventfees');
    }

    $problems = array();

    if (@$_POST['delete']) {

         if ($evp && $evp->id) {
            $outcome = $evp->Delete();
            if (is_a($outcome, 'Error')) return $outcome;
        }
        if ($custom) {
            redirect("Location: " . url_smarty(array('page' => 'editcustomeventpages', 'id' => @$_GET['id']), $custom));
        } elseif ($news) {
            redirect("Location: " . url_smarty(array('page' => 'editnews', 'id' => @$_GET['id']), $custom));
        } else {
            redirect("Location: " . url_smarty(array('page' => 'editeventpages', 'id' => @$_GET['id']), $custom));
        }
        die();
    }

    $title = @$_POST['title'];
    $content = @$_POST['textcontent'];

    if (($custom || $news) && $title == '') $problems['title'] = translate('FormError_NotEmpty');

    if (count($problems)) {
        $error = new Error();
        $error->title = translate('title_is_mandatory');
        $error->function = 'InputProcessing:edit_event_page:processForm';
        $error->cause = array_keys($problems);
        $error->data = $problems;

        return $error;
    }

    if (!$evp) {
        $evp = new TextContent(array());
        $evp->event = $event->id;

        if (is_numeric(@$_GET['content']) || @$_GET['content'] == '*') {
            if ($custom) {
                $evp->type = 'custom';
            } elseif ($news) {
                $evp->type = 'news';
            } else {
                return Error::InternalError();
            }
        } else {
            $evp->type = @$_GET['content'];
        }
    }

    $evp->title = $title;
    $evp->content = $content;

    if (!@$_POST['preview']) {
        $result = $evp->save();
    } else {
        $evp->FormatText();

        return $evp;
    }

    if (is_a($result, 'Error')) return $result;

    if ($custom) {
        redirect("Location: " . url_smarty(array('page' => 'editcustomeventpages', 'id' => @$_GET['id']), $custom));
    } elseif ($news) {
        redirect("Location: " . url_smarty(array('page' => 'editnews', 'id' => @$_GET['id']), $custom));
    } else {
        redirect("Location: " . url_smarty(array('page' => 'editeventpages', 'id' => @$_GET['id']), $custom));
    }
    die();
}
