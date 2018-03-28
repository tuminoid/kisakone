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

{if $pdga}
    {assign var=country value=$pdga_country}
    {if !$country}{assign var=country value='FI'}{/if}
    <tr>
        <td style="width: 200px"><label for="pdga_number">{translate id=pdga_number}:</label></td>
        <td><span id="pdga_number"><a href="http://www.pdga.com/player/{$player->pdga}">{$pdga}</a></span></td>
    </tr>
    <tr>
        <td><label for="pdga_membership_status">{translate id=pdga_membership}:</label></td>
        <td><span id="pdga_membership_status">{translate id=pdga_membership_$pdga_membership_status}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_official_status">{translate id=pdga_official}:</label></td>
        <td><span id="pdga_official_status">{translate id=pdga_official_$pdga_official_status}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_rating">{translate id=pdga_rating}:</label></td>
        <td><span id="pdga_rating">{$pdga_rating}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_status">{translate id=pdga_status}:</label></td>
        <td><span id="pdga_status">{translate id=pdga_status_$pdga_classification}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_birth_year">{translate id=user_yearofbirth}:</label></td>
        <td><span id="pdga_birth_year">{$pdga_birth_year}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_gender">{translate id=user_gender}:</label></td>
        <td><span id="pdga_gender">{translate id=pdga_gender_$pdga_gender}</span></td>
    </tr>
    <tr>
        <td><label for="pdga_country">{translate id='pdga_country'}:</label></td>
        <td><span name="pdga_country"><span class="flag-icon flag-icon-{$country|lower}"></span>{if $pdga_state}{$pdga_state}, {/if}{$pdga_country}</span></td>
    </tr>
{/if}
