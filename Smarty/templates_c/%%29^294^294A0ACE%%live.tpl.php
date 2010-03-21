<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:11
         compiled from javascript/live.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'javascript/live.tpl', 56, false),array('function', 'translate', 'javascript/live.tpl', 85, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%29^294^294A0ACE%%live.tpl.inc'] = '8d4e71df39c723b7c184bc2fa0db48d9'; ?> var lastUpdate = <?php echo time(); ?>
;
<?php echo '

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
		dataType: \'json\',
		error: liveError,
		success: handleLiveUpdateData,
		url: "'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8d4e71df39c723b7c184bc2fa0db48d9#0}'; endif;echo url_smarty(array('page' => 'liveresultdata'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8d4e71df39c723b7c184bc2fa0db48d9#0}'; endif;?>
<?php echo '"
		
		
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
		alert("'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8d4e71df39c723b7c184bc2fa0db48d9#1}'; endif;echo translate_smarty(array('id' => 'live_update_failing'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8d4e71df39c723b7c184bc2fa0db48d9#1}'; endif;?>
<?php echo '");
	} else {
		scheduleLiveUpdate();
	}
}


'; ?>
