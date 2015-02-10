{*
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Layout after content
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
</td>
<td id="helpcontainer" {if !$smarty.get.showhelp}style="display: none"{/if}>{if $smarty.get.showhelp}
{capture assign=fullhelpfile}help/{$helpfile}.tpl{/capture}
{include file=$fullhelpfile}
{/if}</td>
{if !$noad && !$smarty.get.showhelp && $ad && $ad->type != 'disabled'}
<td id="adbannercontainer">
     {include file='include/adbanner.tpl'}
</td>
{/if}
</tr>
</table>
</body>
</html>
