{**
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 *
 * Live result update javascript code
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
 var lastUpdate = {$smarty.now};
{literal}

var liveUpdateRate;
var liveChangeCallback;
var liveDoneCallback;
var liveEventId;
var errors = 0;
var nolive = false;
var liveRound;

function initializeLiveUpdate(updateRate, eventId, roundId, changeCallback, doneCallback) {
	liveUpdateRate = updateRate;
	liveChangeCallback = changeCallback;
	liveDoneCallback = doneCallback;
	liveEventId = eventId;
	liveRound = roundId;
	
	scheduleLiveUpdate();
	
}

function scheduleLiveUpdate() {
	setTimeout(refreshLiveUpdateData, liveUpdateRate * 1000);
}

function refreshLiveUpdateData() {
		
	jQuery.ajax({
		cache: false,
		data: {id: liveEventId, lastUpdate: lastUpdate, round: liveRound},
		dataType: 'json',
		error: liveError,
		success: handleLiveUpdateData,
		url: "{/literal}{url page=liveresultdata}{literal}"
		
		
	});
	

	return true;

}

function handleLiveUpdateData(data) {
	if (nolive) return;
	errors = 0;
	
	lastUpdate = data.updatedAt;
	var count = 0;
	for (var i in data.updates) {
		liveChangeCallback(data.updates[i]);
		count++;
	}
	//alert(count);
	liveDoneCallback();
	
	scheduleLiveUpdate();
}

function liveError(a, x) {
	errors++;
	if (errors == 1) {
		alert("{/literal}{translate id=live_update_failing}{literal}");
	} else {
		scheduleLiveUpdate();
	}
}


{/literal}
