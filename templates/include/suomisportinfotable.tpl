{**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2018 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * PDGA information table for inclusion to any page that
 * has SmartifyPDGA called on it.
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

{if $suomisport_licence_valid_until}
    <tr>
        <td style="width: 200px"><label for="player_name">{translate id=name}:</label></td>
        <td><span id="player_name">{$suomisport_player_fullname}</span></td>
    </tr>
    <tr>
        <td><label for="player_club">{translate id='clubname'}:</label></td>
        <td><span id="player_club">{$suomisport_club_name} ({$suomisport_club_shortname})</span></td>
    </tr>
    <tr>
        <td><label for="player_sportid">{translate id=sportid_number}:</label></td>
        <td><span id="player_sportid">{$suomisport_player_sportid}</span></td>
    </tr>
    <tr>
        <td><label for="player_pdga">{translate id=pdga_number}:</label></td>
        <td><span id="player_pdga"><a href="http://www.pdga.com/player/{$player->pdga}">{$suomisport_player_pdga}</a></span></td>
    </tr>
    <tr>
        <td><label for="player_birthyear">{translate id=user_yearofbirth}:</label></td>
        <td><span id="player_birthyear">{$suomisport_player_birthyear}</span></td>
    </tr>
    <tr>
        <td><label for="player_gender">{translate id=user_gender}:</label></td>
        <td><span id="player_gender">{translate id=pdga_gender_$suomisport_player_gender_short}</span></td>
    </tr>
    <tr>
        <td><label for="player_nationality">{translate id='nationality'}:</label></td>
        <td><span id="player_nationality"><span class="flag-icon flag-icon-{$suomisport_player_nationality|lower}"></span>{$suomisport_player_nationality}</span></td>
    </tr>
    <tr>
        <td><label for="licence_valid">{translate id='license'}:</label></td>
        <td><span id="licence_valid">
        {if $suomisport_licence_valid}
            {translate id='suomisport_licence_valid_until' until=$suomisport_licence_valid_until}
        {else}
            {translate id='suomisport_licence_notvalid'}
        {/if}
        </span></td>
    </tr>
{else}
    <p>{translate id=suomisport_sportid_not_entered}</p>
{/if}
