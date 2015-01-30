{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * Error display page
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
{translate id=$error->title assign='title'}
{include file='include/header.tpl'}

<p>{translate id='error_occured'}</p>
<p>{$error->description}</p>
<p>{translate id='error_nowwhat'}</p>

{if $admin}
    <table class="narrow error">
        <tr>
            <td>Cause</td><td>{$error->cause|escape}</td>
        </tr>
        <tr>
            <td>InternalDescription</td><td>{$error->internalDescription|escape}</td>
        </tr>
        <tr>
            <td>Function</td><td>{$error->function|escape}</td>
        </tr>
        <tr>
            <td>Backtrace</td><td><pre>{$backtrace|escape|nl2br}</pre></td>
        </tr>
    </table>

{/if}

{include file='include/footer.tpl'}
