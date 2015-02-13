<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * This file defines the File class as well as file management functionality
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
class File
{
    var $filename;
    var $displayName;
    var $type;
    var $id;

    function File($data)
    {
        foreach ($data as $key => $value) {
            $fieldName = core_ProduceFieldName($key);
            $this->$fieldName = $value;
        }
    }
}

/**
 * This function stores (the sole) uploaded image in the images/uploaded
 * folder. ID of the created File record is returned on success.
 */
function StoreUploadedImage($type)
{
    if (count($_FILES) != 1) {
        return new Error();
    }

    $keys = array_keys($_FILES);
    $file = $_FILES[$keys[0]];

    $original_name = $file['name'];
    $current_name = $file['tmp_name'];
    $extension = core_GetExtension($original_name);
    $desired_name = core_ChooseUploadFilename($extension);

    $validExtensions = array(".png", ".jpg", ".jpeg", ".gif");

    if (!in_array(strtolower($extension), $validExtensions)) {
        return Error::AccessDenied();
    }

    $displayName = core_GetUniqueFileDisplayName($original_name, $type);

    copy($current_name, "images/uploaded/" . $desired_name);

    return CreateFileRecord($desired_name, $displayName, $type);
}

/**
 * Listings with multiple files with the same name are not nice. This function
 * appends a numeric value (such as "image.jpg (2)" ) to the name if necessary.
 *
 * Names are type-specific, so in addition to the normal filename the type must
 * be entered as well.
 */
function core_GetUniqueFileDisplayName($base, $type)
{
    $files = GetFilesOfType($type);
    $names = array();
    foreach ($files as $file)
        $names[$file->displayName] = true;

    if (@$names[$base]) {
        $ind = 2;
        do {
            $nfn = $base . ' (' . $ind . ')';

            if (!@$names[$nfn]) {
                return $nfn;
            }

            $ind++;
        }
        while (true);
    }
    else {
        return $base;
    }
}

/**
 * Returns the extension of a filename. There's a probably a built-in function for this
 *  as well
 */
function core_GetExtension($filename)
{
    $dot = strrpos($filename, '.');
    $slash = strrpos($filename, '/');
    $backslash = strrpos($filename, '\\');

    if ($dot < $slash || $dot < $backslash)
        return '';
    return substr($filename, $dot);
}

/**
 * Chosoes a name for an uploaded file. Extension of the file must be provided.
 */
function core_ChooseUploadFilename($extension)
{
    $dir = "images/uploaded/";
    do {
        $filename = core_GenerateFilename ();
        $fullname = $dir . $filename . $extension;
    }
    while (file_exists($fullname));

    return $filename . $extension;
}

/**
 * Generates a rendom filename
 */
function core_GenerateFilename()
{
    $length = rand(8, 15);
    $chars = "abcdefghijklmnopqrstuvxyz_1234567890";
    $name = '';
    $listLen = strlen($chars);
    while ($length--) {
        $name .= $chars[rand(0, $listLen - 1)];
    }

    return $name;
}
