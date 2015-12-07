{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Payouts edit interface
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

{translate assign=title id=payout_title}
{include file='include/header.tpl'}

<h2>{translate id=payout_title}</h2>

{if $error}
    <p class="error">{translate id=FormError_Summary}</p>
{/if}

<form method="post">
    <input name="formid" type="hidden" value="edit_payout" />

    <br />
    <input type="submit" name="submit" value="{translate id=form_save}" />

</form>

{include file='include/footer.tpl' noad=1}
