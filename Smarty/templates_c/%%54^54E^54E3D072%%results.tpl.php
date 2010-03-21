<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:09
         compiled from eventviews/results.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'eventviews/results.tpl', 106, false),array('function', 'math', 'eventviews/results.tpl', 108, false),array('function', 'translate', 'eventviews/results.tpl', 113, false),array('function', 'url', 'eventviews/results.tpl', 117, false),array('function', 'counter', 'eventviews/results.tpl', 139, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%54^54E^54E3D072%%results.tpl.inc'] = '75fabe38e7412e30a013507bb43be8a2'; ?> <?php if ($this->_tpl_vars['mode'] != 'body'): ?>
 <style type="text/css"><?php echo '
    .resultrow td, .resultrow th {
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
        
        margin: 0;
    }
    
    
    
    .results td, .results th {
        background-color: #EEE;
        text-align: center;
        border: 2px solid white;
    }
    
    .penalty_hidden { display: none !important; }
    
    
    .in, .out {
        background-color: #caffca !important;
    }
    
    .round_selection_table .selected {
        background-color: #DDD;
        
    }
    
    .results {
        border-collapse: collapse;
    }
    
    .rightside {
        text-align: right !important;
    }
    .leftside {
        text-align: left !important;
    }
    
    .thr {
        
    }
    
    .plusminus_neg { color: #F00; }
    .plusminus_pos { color: #0000aa; font-weight: bold; }
    
    .rm {
        background-color: #f6a690 !important;
    }
    
    .rp1 {
        background-color: #aacfcf !important;
    }
    .pr {
        background-color: #f6F6F6 !important;
    }
    
    .rp {
        background-color: #51787e !important;
        color: white;
    }
    
    .penaltytd { background-color: white !important}
    
    .penalty {
        background-color: #EEE !important;
        color: red;
        min-width: 16px;
        
        
    }
    
'; ?>
</style>
<?php else: ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>


<table class="round_selection_table narrow" >
    <?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['classid'] => $this->_tpl_vars['class']):
?>
        <tr>
            <th><?php echo ((is_array($_tmp=$this->_tpl_vars['class']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
        <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
        <?php echo smarty_function_math(array('assign' => 'roundnum','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

            
            <?php if ($this->_tpl_vars['round']->id == $this->_tpl_vars['the_round']->id): ?>
                <td class="selected">
                <a href="#c<?php echo $this->_tpl_vars['class']->name; ?>
">
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#0}'; endif;echo translate_smarty(array('id' => 'round_title','number' => $this->_tpl_vars['roundnum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#0}'; endif;?>
</a></td>
            <?php else: ?>
                 <td>
            
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#1}'; endif;echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => $_GET['view'],'round' => $this->_tpl_vars['roundnum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#1}'; endif;?>
#c<?php echo $this->_tpl_vars['class']->name; ?>
">
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#2}'; endif;echo translate_smarty(array('id' => 'round_title','number' => $this->_tpl_vars['roundnum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#2}'; endif;?>
</a>
                </td>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>


<table class="results ">
   
    
    <?php $_from = $this->_tpl_vars['resultsByClass']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class'] => $this->_tpl_vars['results']):
?>
    <tr style="border: none" class="class_border">
        <?php echo smarty_function_math(array('assign' => 'colspan','equation' => "2+x+2+2",'x' => $this->_tpl_vars['round']->NumHoles()), $this);?>

        <td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
" style="background-color: white" class="leftside">
            <a name="c<?php echo $this->_tpl_vars['class']; ?>
"></a>
            <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['class'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
        </td>
        
    </tr>
    <?php echo smarty_function_counter(array('assign' => 'rowind','start' => -1), $this);?>

    <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
    <?php if ($this->_tpl_vars['result']['Total'] != 'not_used'): ?>
        <?php echo smarty_function_counter(array('assign' => 'rowind'), $this);?>

        <?php if ($this->_tpl_vars['rowind'] % 10 == 0): ?>
        <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>
            <tr class="thr">
                <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#3}'; endif;echo translate_smarty(array('id' => 'result_pos'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#3}'; endif;?>
</th>
                <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#4}'; endif;echo translate_smarty(array('id' => 'result_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#4}'; endif;?>
</th>
                <th></th>
                <th colspan="<?php echo smarty_function_math(array('equation' => "x+2",'x' => $this->_tpl_vars['round']->NumHoles()), $this);?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#5}'; endif;echo translate_smarty(array('id' => 'result_score'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#5}'; endif;?>
</th>
               
               
                <th colspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#6}'; endif;echo translate_smarty(array('id' => 'round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#6}'; endif;?>
</th>
                <th colspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#7}'; endif;echo translate_smarty(array('id' => 'cumulative'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#7}'; endif;?>
</th>
            </tr>
            <tr class="thr">
                <th class="rightside">
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#8}'; endif;echo translate_smarty(array('id' => 'hole_num'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#8}'; endif;?>
<br />
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#9}'; endif;echo translate_smarty(array('id' => 'hole_par'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#9}'; endif;?>

                </th>
                <?php $this->assign('parSoFar', 0); ?>
                <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>
                        <?php echo smarty_function_math(array('assign' => 'parSoFar','equation' => "x+y",'x' => $this->_tpl_vars['parSoFar'],'y' => $this->_tpl_vars['hole']->par), $this);?>
                        
                        <th><?php echo $this->_tpl_vars['hole']->holeNumber; ?>
<br /><?php echo $this->_tpl_vars['hole']->par; ?>
</th>
                        <?php if ($this->_tpl_vars['hole']->holeNumber == $this->_tpl_vars['out_hole_index']): ?><th class="out"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#10}'; endif;echo translate_smarty(array('id' => 'hole_out'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#10}'; endif;?>
<br /><?php echo $this->_tpl_vars['parSoFar']; ?>
<?php $this->assign('parSoFar', 0); ?></th><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <th class="in"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#11}'; endif;echo translate_smarty(array('id' => 'hole_in'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#11}'; endif;?>
<br /><?php echo $this->_tpl_vars['parSoFar']; ?>
</th>
                 <th>+/-</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#12}'; endif;echo translate_smarty(array('id' => 'result'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#12}'; endif;?>
</th>
                <th>+/-</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#13}'; endif;echo translate_smarty(array('id' => 'result'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#13}'; endif;?>
</th>
            </tr>
            
            <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>
        <?php endif; ?>
<tr class="resultrow">

<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_pos"><?php echo $this->_tpl_vars['result']['Standing']; ?>
</td>
<td colspan="2" class="leftside"><?php echo ((is_array($_tmp=$this->_tpl_vars['result']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['result']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>

<?php $this->assign('inout', 0); ?>
<?php $this->assign('dnfd', false); ?>
<?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>

<?php $this->assign('holenum', $this->_tpl_vars['hole']->holeNumber); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['hole']->round; ?>
_<?php echo $this->_tpl_vars['hole']->holeNumber; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('hr_id', ob_get_contents());ob_end_clean(); ?>
<?php $this->assign('holeresult', $this->_tpl_vars['result']['Results'][$this->_tpl_vars['holenum']]['Result']); ?>
<?php if (! $this->_tpl_vars['holeresult']): ?><?php $this->assign('holeresult', 0); ?><?php endif; ?>
<?php echo smarty_function_math(array('assign' => 'inout','equation' => "x+y",'x' => $this->_tpl_vars['inout'],'y' => $this->_tpl_vars['holeresult']), $this);?>


<?php if ($this->_tpl_vars['holeresult'] >= 99): ?><?php $this->assign('dnfd', true); ?><?php endif; ?>

<?php echo smarty_function_math(array('assign' => 'pardiff','equation' => "res-par",'res' => $this->_tpl_vars['holeresult'],'par' => $this->_tpl_vars['hole']->par), $this);?>

<?php if ($this->_tpl_vars['holeresult'] == 0): ?><?php $this->assign('holeclass', 'rz'); ?>
<?php elseif ($this->_tpl_vars['pardiff'] == 0): ?><?php $this->assign('holeclass', 'pr'); ?>
<?php elseif ($this->_tpl_vars['pardiff'] < 0): ?><?php $this->assign('holeclass', 'rm'); ?>
<?php elseif ($this->_tpl_vars['pardiff'] == 1): ?><?php $this->assign('holeclass', 'rp1'); ?>
<?php elseif ($this->_tpl_vars['pardiff'] > 1): ?><?php $this->assign('holeclass', 'rp'); ?>
<?php endif; ?>

<td class="<?php echo $this->_tpl_vars['holeclass']; ?>
"  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_<?php echo $this->_tpl_vars['hr_id']; ?>
">
    <?php if ($this->_tpl_vars['holeresult'] != 0): ?><?php echo $this->_tpl_vars['holeresult']; ?>
<?php endif; ?></td>


<?php if ($this->_tpl_vars['hole']->holeNumber == $this->_tpl_vars['out_hole_index']): ?>
<td class="out" id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_out">
    <?php if ($this->_tpl_vars['dnfd']): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#14}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#14}'; endif;?>
<?php else: ?>
    <?php echo $this->_tpl_vars['inout']; ?>
<?php endif; ?>
    <?php $this->assign('inout', 0); ?>
</td><?php endif; ?>

<?php endforeach; endif; unset($_from); ?>

<td class="in" id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_in">
<?php if ($this->_tpl_vars['dnfd']): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#15}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#15}'; endif;?>
<?php else: ?>
    <?php echo $this->_tpl_vars['inout']; ?>
<?php endif; ?>

</td>

<?php if ($this->_tpl_vars['result']['DidNotFinish']): ?>
 <td  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_rpm"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#16}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#16}'; endif;?>
</td>
 <td  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_rt"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#17}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#17}'; endif;?>
</td>
 <td class="cpm" id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_cpm"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#18}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#18}'; endif;?>
</td>
<td  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_ct"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#19}'; endif;echo translate_smarty(array('id' => 'result_dnf'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#19}'; endif;?>
</td>
<?php else: ?>
<td class="plusminus_<?php if ($this->_tpl_vars['result']['RoundPlusMinus'] < 0): ?>neg<?php elseif ($this->_tpl_vars['result']['RoundPlusMinus'] > 0): ?>pos<?php else: ?>zero<?php endif; ?>"
id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_rpm"><?php echo $this->_tpl_vars['result']['RoundPlusMinus']; ?>
</td>
<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_rt"><?php echo $this->_tpl_vars['result']['Total']; ?>
</td>
<td class="cpm plusminus_<?php if ($this->_tpl_vars['result']['CumulativePlusminus'] < 0): ?>neg<?php elseif ($this->_tpl_vars['result']['CumulativePlusminus'] > 0): ?>pos<?php else: ?>zero<?php endif; ?>"
id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_cpm"><?php echo $this->_tpl_vars['result']['CumulativePlusminus']; ?>
</td>
<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_ct"><?php echo $this->_tpl_vars['result']['CumulativeTotal']; ?>
</td>
<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_p" class="penalty_hidden"><?php echo $this->_tpl_vars['result']['Penalty']; ?>
</td>
<?php endif; ?>
<?php if ($this->_tpl_vars['result']['Penalty']): ?>
<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_px" class="penaltytd penalty">                
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#20}'; endif;echo translate_smarty(array('id' => 'result_penalty_panel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#20}'; endif;?>


</td>
<?php else: ?>
<td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_px" class="penaltytd">                               
</td>
<?php endif; ?>
            
        </tr>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>
        <tr><td></td></tr>
</table>


    <script type="text/javascript" src="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#21}'; endif;echo url_smarty(array('page' => "javascript/live"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#21}'; endif;?>
"></script>
    
    <script type="text/javascript">
    //<![CDATA[
    var holes = new Array();
    <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
        holes[<?php echo $this->_tpl_vars['hole']->id; ?>
] = <?php echo $this->_tpl_vars['hole']->par; ?>
;
    <?php endforeach; endif; unset($_from); ?>
    holes["p"] = 0;
    var eventid = <?php echo $this->_tpl_vars['eventid']; ?>
;
    
    var roundid = <?php echo $this->_tpl_vars['roundid']; ?>
;
    var out_hole_index = <?php echo $this->_tpl_vars['out_hole_index']; ?>
;
    var penaltyText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:75fabe38e7412e30a013507bb43be8a2#22}'; endif;echo translate_smarty(array('id' => 'result_penalty_panel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:75fabe38e7412e30a013507bb43be8a2#22}'; endif;?>
";

    <?php echo '
    
    
    
    $(document).ready(function(){
        '; ?>
<?php if ($this->_tpl_vars['live']): ?>
        initializeLiveUpdate(15, eventid, roundid, updateField, updateBatchDone);
        
        <?php endif; ?><?php echo '
        
        
        $("#stop").click(function(){ nolive=true; });
        
    });
    
    var anyChanges = false;
    var anySwaps = false;
    
    function updateField(data) {
        if (data.hole == "sd") return;
        
        var fieldid;
        if (data.hole == "p") {
            updatePenaltyField(data);
             fieldid = "r" + data.pid + "_p";
        } else {
            fieldid = "r" + data.pid + "_" + data.round + "_" + data.holeNum;
        }
        
        
        
        
        var field = document.getElementById(fieldid);
        if (field) {
            var current = parseInt(field.innerText || field.textContent);
            if (isNaN( current )) current = 0;
            var diff = data.value - current;
            
            
            
            if (diff) {
                if (current == 99 || data.value == 99) {
                    window.location.reload();
                }
                
                if (field.firstChild) field.removeChild(field.childNodes[0]);
                var newTextNode = document.createTextNode(data.value);
                field.appendChild(newTextNode);
                $(field).effect("highlight", {color: \'#5F5\'}, 30000);
                
                // Round
                {
                    var totfield = document.getElementById("r" + data.pid + "_rt");
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: \'#55F\'}, 30000);
                                    
                    var pmfield = document.getElementById("r" + data.pid + "_rpm");
                    
                    var cpm = parseInt(pmfield.innerText || pmfield.textContent);
                    if (isNaN(cpm)) cpm = 0;
                    
                    
                    var par;
                    if (data.hole == "p") par = 0;
                    else par = holes[data.hole];
                    
                    if (data.value == 0) {
                        newpm = cpm - (current - par);
                    } else if (current == 0) {
                        newpm = cpm + (data.value - par);
                    } else {
                        newpm = cpm + diff;
                    }
                    
                    if (pmfield.childNodes.length) pmfield.removeChild(pmfield.childNodes[0]);
                    pmfield.appendChild(document.createTextNode(newpm));
                    $(pmfield).effect("highlight", {color: \'#55F\'}, 30000);
                }
                
                
                // Cumulative
                {
                    var totfield = document.getElementById("r" + data.pid + "_ct");
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: \'#55F\'}, 30000);
                                    
                    var pmfield = document.getElementById("r" + data.pid + "_cpm");
                    
                    var cpm = parseInt(pmfield.innerText || pmfield.textContent);
                    if (isNaN(cpm)) cpm = 0;
                    
                    var par = holes[data.hole];
                    
                    if (data.value == 0) {
                        newpm = cpm - (current - par);
                    } else if (current == 0) {
                        newpm = cpm + (data.value - par);
                    } else {
                        newpm = cpm + diff;
                    }
                    
                    if (pmfield.childNodes.length)pmfield.removeChild(pmfield.childNodes[0]);
                    pmfield.appendChild(document.createTextNode(newpm));
                    $(pmfield).effect("highlight", {color: \'#55F\'}, 30000);
                }
                
                if (data.hole != "sd" && data.hole != "p") {
                    var suffix;
                    if (data.holenum <= out_hole_index) {
                        suffix = "out";
                    } else {
                        suffix = "in";
                    }
                    
                    var totfield = document.getElementById("r" + data.pid + "_" + suffix);
                    var ctot = parseInt(totfield.innerText || totfield.textContent);
                    if (isNaN(ctot)) ctot = 0;
                    
                    if (totfield.childNodes.length) totfield.removeChild(totfield.childNodes[0]);
                    totfield.appendChild(document.createTextNode(ctot + diff));
                    $(totfield).effect("highlight", {color: \'#55F\'}, 30000);
                }
                
                if (diff < 0)  {
                    moveUpIfNecessary(field);
                } else {
                    moveDownIfNecessary(field);
                }
                
                if (anySwaps) redoPositions();
                
            }
            

        } else {
//            alert(\'reloading  \' + fieldid);
            window.location.reload();
        }
        anyChanges = true;
    }
    
    function updateBatchDone() {        
        anyChanges = false;
    }
    
    function redoPositions() {
        var last = -9999;
        var lastpos = 0;
        
        $(".tr").each(function() {
            if (tr.className != \'resultrow\') {
               if (tr.className = "class_border") {
                  last = -9999;
                  lastpos = 0;
                  return;
               }
               return;
            }
            var val = parseInt($(this).find(".cpm").text());
            
            if (val == last) {
                setPosition(this, lastpos);
            } else {
                lastpos++;
                setPosition(this, lastpos);
                last = val;
            }
        });
    }
    
    function setPosition(tr, pos) {
        var td = $(tr).find("td").get(0);
        
        $(td).empty();
        td.appendChild(document.createTextNode(pos));
        
    }
    
    function updatePenaltyField(data) {
        var field = $("#r" + data.pid + "_px");
        if (!field.get(0)) return;
        if (!data.value) {
            field.empty();            
            field.get(0).className = "penaltytd";
        } else {

            field.empty();
            field.get(0).className = "penaltytd penalty";
            field.get(0).appendChild(document.createTextNode(penaltyText));
        }
    }
    
    function moveDownIfNecessary(field) {
        
        var row = $(field).closest("tr").get(0);
        var nextrow = nextResultRow(row);
        
        if (!nextrow) return;
        
        var c = compareRows(row, nextrow);
        
        if (c == 1) {
            swapRows(row, nextrow);
            anySwaps = true;
            moveDownIfNecessary(field);
        }
        
    }
    
    function moveUpIfNecessary(field) {
        var row = $(field).closest("tr").get(0);
        var nextrow = prevResultRow(row);
        
        if (!nextrow) return;
        
        
        var c = compareRows(row, nextrow);
        
        if (c == -1) {
            swapRows(row, nextrow);
            anySwaps = true;
            moveUpIfNecessary(field);
        }
        
    }
    
    function prevResultRow(row) {
        var r=  row.previousSibling;
        
        while (r) {
            if (r.tagName && r.tagName.match(/tr/i)) {
                if (r.className == \'resultrow\') return r;
                if (r.className == \'class_border\') return null;
            }
            
            r = r.previousSibling;
        }
        return null;
    }
    
    function nextResultRow(row) {
        var r = row.nextSibling;
        
        while (r) {
            if (r.tagName && r.tagName.match(/tr/i)) {
                if (r.className == \'resultrow\') return r;
                if (r.className == \'class_border\') return null;
            }
            
            r = r.nextSibling;
        }
        return null;
    }
    
    function compareRows(a, b) {
        
        var acell = $(a).find(".cpm").get(0);
        var bcell = $(b).find(".cpm").get(0);
        
        if (!acell || !bcell) {
            if (acell == bcell) return 0;
            if (!acell) return 1;
            return -1;
        }
        
        var avalue = parseInt(acell.textContent || acell.innerText);
        var bvalue = parseInt(bcell.textContent || bcell.innerText);
        
        
        
        if (avalue == bvalue) return 0;
        if (avalue < bvalue) return -1;
        
        
        return 1;
        
    }
    
    function swapRows(a, b) {       
        var aa = a.nextSibling;
        var ab = b.nextSibling;
        
        b.parentNode.insertBefore(a, ab);
        a.parentNode.insertBefore(b, aa);
    }
    
    '; ?>

    
    
    //]]>
    </script>    

<?php endif; ?>