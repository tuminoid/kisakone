{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmõ
 *
 * If event is locked, this page shows error message telling edits aren't possible.
 * If JS is enabled, editing controls are also disabled
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
 {if $locked}
    <p class="error">{translate id=event_is_locked_cant_edit}</p>
    <script type="text/javascript">
    //<![CDATA[
    {literal}
    $(document).ready(function(){
        $("input").each(function(){this.disabled=true;});
        $("select").each(function(){this.disabled=true;});
        $("button").each(function(){this.disabled=true;});
    });

    {/literal}


    //]]>
    </script>
{/if}
