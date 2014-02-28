{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tumi@tumi.fi>
 *
 * Terms and conditions page
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
 * *}
 <!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      {* We don't want the regular layout here, just plain minimum*}
      <title>{translate id=terms_and_conditions} - {translate id=site_name}</title>
      <link rel="stylesheet" href="{$url_base}ui/elements/style.css" type="text/css" />
      <script type="text/javascript" src="{$url_base}ui/elements/jquery/jquery-1.11.0.min.js"></script>
</head>
<body>
    <div id="content">
    {$content}
    </div>
</body>
</html>
