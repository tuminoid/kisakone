{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Post-login redirect
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

{if $type == 'login'}
{translate assign=title id=loginredirect_title}
{translate assign=text id=loginredirect_text}
{assign var=url value=$smarty.server.REQUEST_URI}
{/if}
{include file=include/header.tpl}

<p>{$text}</p>

<p><a href="{$url|escape}">{translate id=redirect_proceed}</a></p>

<script type="text/javascript">
//<![CDATA[
var url = "{$url|escape:"javascript"}";
{literal}

setTimeout(doRedirect, 3000);

function doRedirect() {
    window.location = url;
}

{/literal}
//]]>
</script>

{include file=include/footer.tpl}
