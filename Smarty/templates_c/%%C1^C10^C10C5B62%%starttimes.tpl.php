<?php /* Smarty version 2.6.26, created on 2010-02-18 20:13:54
         compiled from starttimes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'starttimes.tpl', 22, false),array('modifier', 'date_format', 'starttimes.tpl', 126, false),array('modifier', 'escape', 'starttimes.tpl', 127, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C1^C10^C10C5B62%%starttimes.tpl.inc'] = 'd6e04c4d8e27e83ebc3e1dbdd293dea9'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#0}'; endif;echo translate_smarty(array('id' => 'starttimes_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#0}'; endif;?>

<?php ob_start(); ?>
<style type="text/css">
<?php echo '
    .groupman ul, .groupman li {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    
    .groupman li {
        padding: 2px;
    }
    
    .beingDragged{
        background-color: #CCC;
    }
    

    
    .droponme {
        border: 2px solid blue;
        
    }
    
    .groupman td {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    
    .groupman .toplist {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    
    .innertable td {
        padding: 3px;
        min-height: 32px;
    }
    
    .grouplist {
        width: 400px;
        float: left;
        
    }
    
    .tagged {
        border: 2px solid green;
    }
    
    .taggedp {
        background-color: #FFA;
        font-weight: bold;
    }
    
    .subclass {
        background-color: #EEE;
        
        padding: 16px;
        margin: 8px;
        max-width: 400px;
    }
    
    
    h2 {
        clear: both;
    }
    

    '; ?>

</style>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('extrahead', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('ui' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "support/eventlockhelper.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



<div class="nojs">
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#1}'; endif;echo translate_smarty(array('id' => 'page_requires_javascript'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#1}'; endif;?>

</div>

<div class="jsonly">
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#2}'; endif;echo translate_smarty(array('id' => 'starttimes_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#2}'; endif;?>
</p>
    
    
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#3}'; endif;echo translate_smarty(array('id' => 'round_starts_at','start' => $this->_tpl_vars['startTime'],'interval' => $this->_tpl_vars['interval']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#3}'; endif;?>
</p>

<form method="post">
    <input type="hidden" name="formid" value="start_times" />
    
    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#4}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#4}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#5}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#5}'; endif;?>
" />
    </div>
    
 
        
        <?php $_from = $this->_tpl_vars['sections']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>
           
            <div class="subclass cid<?php echo $this->_tpl_vars['section']->id; ?>
" id="c_<?php echo $this->_tpl_vars['section']->id; ?>
">
                <?php $this->assign('estimate', $this->_tpl_vars['section']->EstimateNumberOfGroups()); ?>
                <span class="groups_in_class" style="display: none"><?php echo $this->_tpl_vars['estimate']; ?>
</span>
                <input type="hidden" class="timeInput" name="time_<?php echo $this->_tpl_vars['section']->id; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['section']->startTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
" />
                <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
                <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#6}'; endif;echo translate_smarty(array('id' => 'start_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#6}'; endif;?>
 <span class="timeText"><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->startTime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</span>
                    <span class="timeType"><?php if ($this->_tpl_vars['section']->startTime): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#7}'; endif;echo translate_smarty(array('id' => 'forced'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#7}'; endif;?>
<?php else: ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#8}'; endif;echo translate_smarty(array('id' => 'automatic'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#8}'; endif;?>
<?php endif; ?></span>
                    <button class="cs"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#9}'; endif;echo translate_smarty(array('id' => 'change_start_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#9}'; endif;?>
</button>                    
                </p>
                <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#10}'; endif;echo translate_smarty(array('id' => 'estimated_number_of_groups','estimate' => $this->_tpl_vars['estimate']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#10}'; endif;?>
</p>
                <input type="checkbox" class="presentCb" name="present_<?php echo $this->_tpl_vars['section']->id; ?>
" <?php if ($this->_tpl_vars['section']->present): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#11}'; endif;echo translate_smarty(array('id' => 'class_present'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#11}'; endif;?>

                <br />
                <div>
                    <button class="ea"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#12}'; endif;echo translate_smarty(array('id' => 'earlier'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#12}'; endif;?>
</button>
                    <button class="la"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#13}'; endif;echo translate_smarty(array('id' => 'later'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#13}'; endif;?>
</button>
                </div>
            </div>            
        <?php endforeach; endif; unset($_from); ?>
        
<div class="forbiddenArea"></div>

<div class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#14}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#14}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#15}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#15}'; endif;?>
" />
    </div>

</form>

<script type="text/javascript">
//<![CDATA[

var changeTimePrompt = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#16}'; endif;echo translate_smarty(array('id' => 'change_time_prompt'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#16}'; endif;?>
";
var automaticText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#17}'; endif;echo translate_smarty(array('id' => 'automatic'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#17}'; endif;?>
";
var forcedText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#18}'; endif;echo translate_smarty(array('id' => 'forced'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#18}'; endif;?>
";
var invalidFormat = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#19}'; endif;echo translate_smarty(array('id' => 'invalid_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#19}'; endif;?>
";

var notPresentText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#20}'; endif;echo translate_smarty(array('id' => 'section_not_present'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6e04c4d8e27e83ebc3e1dbdd293dea9#20}'; endif;?>
";

var startTime = '<?php echo $this->_tpl_vars['startTime']; ?>
';
var interval = <?php echo $this->_tpl_vars['interval']; ?>
;

<?php echo '



$("document").ready(function(){
   AttachHandlers($(".subclass"));
   
  RedoTimes();
    
});

function AttachHandlers(to) {
    to.find(".cs").click(changeStartTime);
    to.find(".ea").click(earlier);
    to.find(".la").click(later);
    to.find(".presentCb").click(RedoTimes);
}

function changeStartTime() {
    
    var div = this.parentNode.parentNode;
    var hidden = $(div).find(".timeInput").get(0);
    var typeSpan = $(div).find(".timeType").get(0);
    
    var evStart = prompt(changeTimePrompt, hidden.value);
    
    if (evStart == undefined) {
        return false;
    }
    
    if (evStart == "") {
        $(typeSpan).empty();
        typeSpan.appendChild(document.createTextNode(automaticText));
        hidden.value = "";
    } else {
        if (!(evStart.match(/\\d\\d?(:\\d\\d)/))) {
            alert(invalidFormat);
            return false;
        }
        
        $(typeSpan).empty();
        typeSpan.appendChild(document.createTextNode(forcedText));
        hidden.value = evStart;
    }
    
    RedoTimes();
    
    return false;
}

function earlier(){
    var theDiv = this.parentNode.parentNode;
    
    
    var before = $(theDiv).prev("div").get(0);
    if (before) {
        if (before.className == "buttonarea") return false;
        $(theDiv).remove();
        
        before.parentNode.insertBefore(theDiv, before);
        
        AttachHandlers($(theDiv));
    }

    RedoTimes();
    return false;
}

function later() {
    var theDiv = this.parentNode.parentNode;
    
    
    var before = $(theDiv).next("div").next("div").get(0);
    if (before) {
        //$(theDiv).next("div").remove();
        $(theDiv).remove();
        
        before.parentNode.insertBefore(theDiv, before);
        
        AttachHandlers($(theDiv));
    }

    RedoTimes();
    return false;
    
}

function RedoTimes() {
    // There\'s probably a better native way to do this as well, but due to time constraints
    // a straightforward manual approach was taken

    var now = startTime.split(\':\');
    var numGroupsInLast = 0;
    
    $(".subclass").each(function(){
        var hidden = $(this).find(".timeInput").get(0);
        var span = $(this).find(".timeText").get(0);
        var groupnumElement = $(this).find(".groups_in_class").get(0);
        var present = $(this).find(".presentCb").get(0).checked;
        
        if (present) {
        
        
            if (hidden.value != \'\') {                
                $(span).empty();
                span.appendChild(document.createTextNode(hidden.value));
                now = hidden.value.split(\':\');
            } else {
                
                now = offsetTime(now, interval * numGroupsInLast);
                
                $(span).empty();
                span.appendChild(document.createTextNode(now[0] + ":" + now[1]));
            }
            numGroupsInLast = parseInt(groupnumElement.innerText || groupnumElement.textContent);
        } else {
            $(span).empty();
            span.appendChild(document.createTextNode(notPresentText));
        }
        
        
    });
}

function offsetTime(time, offset) {
    var hourString = time[0];
    if (hourString.substring(0, 1) == "0" && hourString != "0") hourString = hourString.substring(1);
    var hours = parseInt(hourString);
    
    var minuteString = time[1];
    if (minuteString.substring(0, 1) == "0" && minuteString != "0") minuteString = minuteString.substring(1);
    
    var minutes = parseInt(minuteString);    
    
    minutes += offset;
    while (minutes >= 60) {
        hours++;
        minutes -= 60;
    }
    
    hours = hours % 24;
    
    if (minutes < 10) minutes = "0" + minutes;
    
    return [hours + "", minutes + ""];
}


'; ?>



//]]>
</script>

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>