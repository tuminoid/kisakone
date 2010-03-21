<?php /* Smarty version 2.6.26, created on 2010-02-16 14:59:31
         compiled from editgroups.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editgroups.tpl', 22, false),array('function', 'initializeGetFormFields', 'editgroups.tpl', 127, false),array('function', 'math', 'editgroups.tpl', 176, false),array('function', 'counter', 'editgroups.tpl', 182, false),array('modifier', 'escape', 'editgroups.tpl', 157, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%7B^7B0^7B043DB8%%editgroups.tpl.inc'] = '3bfe3c676f709288a2325bc7a2416eb8'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#0}'; endif;echo translate_smarty(array('id' => 'editgroups_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#0}'; endif;?>

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
        -moz-border-radius: 1em;
        
    }
    
    .beingDragged{
        background-color: #CCC;
    }
    

    
    .droponme {
        border: 2px solid blue !important;
        
    }
    
    .groupman td {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    
    .tag_person {
        cursor: pointer;        
    }
    .tag_person:hover {
        text-decoration: underline;
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
        border: 2px solid green !important;
    }
    
    .taggedp {
        background-color: #FFA;
        font-weight: bold;
    }
    
    h2 {
        clear: both;
    }
    
    .needs_splitter li {
        
        margin-left: 32px;
    }
    
    
    .toplist {
        border: 1px outset gray;
        padding: 0;
        margin: 2px;
    }
    
    .tag_group {
        margin-top: -2px;
        border: 1px outset blue;
        background-color: #CCF;
        cursor: move;
        -moz-border-radius: 0.25em;
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

<div style="display: none">
    <input type="text" value="2" id="cols" /> <button id="reorg">Reorganize_Columns_Now!</button>

</div>


<?php if ($this->_tpl_vars['suggestRegeneration']): ?>
    <div class="error">
        <form method="get">
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#1}'; endif;echo initializeGetFormFields_Smarty(array('regenerate' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#1}'; endif;?>

            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#2}'; endif;echo translate_smarty(array('id' => 'regenerate_groups_text_2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#2}'; endif;?>
</p>
            <p><input name="regenerate" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#3}'; endif;echo translate_smarty(array('id' => 'regenerate_groups'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#3}'; endif;?>
" /></p>
        </form>
    </div>
<?php else: ?>
    <div class="searcharea">
        <form method="get">
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#4}'; endif;echo initializeGetFormFields_Smarty(array('regenerate' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#4}'; endif;?>

            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#5}'; endif;echo translate_smarty(array('id' => 'regenerate_groups_text_1'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#5}'; endif;?>
</p>
            <p><input name="regenerate"  type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#6}'; endif;echo translate_smarty(array('id' => 'regenerate_groups'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#6}'; endif;?>
" /></p>
        </form>
    </div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="formid" value="edit_groups" />
<div  class="buttonarea">
    <p style="float: right; max-width: 200px;"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#7}'; endif;echo translate_smarty(array('id' => 'edit_groups_quickhelp'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#7}'; endif;?>
</p>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#8}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#8}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#9}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#9}'; endif;?>
" />
        <button style="margin-left: 64px" id="reba"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#10}'; endif;echo translate_smarty(array('id' => 'rebalance_groups'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#10}'; endif;?>
</button>
        <p><input class="all" type="checkbox" name="done" <?php if ($this->_tpl_vars['round']->groupsFinished !== null): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#11}'; endif;echo translate_smarty(array('id' => 'groups_finished'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#11}'; endif;?>
</p>

    </div>


<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>
    <?php if ($this->_tpl_vars['section']->present): ?>
    <div class="groupman" >
        <input type="hidden" name="e[]" value="sid<?php echo ((is_array($_tmp=$this->_tpl_vars['section']->id)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
        <ul class="oddrows grouplist"  style="">            
            <?php $_from = $this->_tpl_vars['section']->GetGroups(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
            <li style="clear: right;" class="toplist">
                <div class="tag_group">
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#12}'; endif;echo translate_smarty(array('id' => 'group_number','number' => $this->_tpl_vars['group']['PoolNumber']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#12}'; endif;?>
,
                    <span class="dispname"><?php echo ((is_array($_tmp=$this->_tpl_vars['group']['DisplayName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>
                    <?php if ($this->_tpl_vars['round']->starttype == 'simultaneous'): ?>
                    <button style="float: right" class="change_hole"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#13}'; endif;echo translate_smarty(array('id' => 'change_hole'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#13}'; endif;?>
</button>
                    <?php endif; ?>
                </div>
                <input type="hidden" class="holenum" name="e[]" value="h<?php echo $this->_tpl_vars['group']['StartingHole']; ?>
" />
                <input type="hidden" name="e[]" value="gid<?php echo ((is_array($_tmp=$this->_tpl_vars['group']['GroupId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                <div class="tcon">
                    <table class="narrow innertable">
                        <tbody>
                            <?php $this->assign('nump', 0); ?>
                        <?php $_from = $this->_tpl_vars['group']['People']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['player']):
?>
                            <?php echo smarty_function_math(array('assign' => 'nump','equation' => "x + 1",'x' => $this->_tpl_vars['nump']), $this);?>

                            <tr class="tag_person">
                                <td style="min-width: 180px;">
                                    <input type="hidden" name="e[]" value="pid<?php echo ((is_array($_tmp=$this->_tpl_vars['player']['PlayerId'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    <span><?php echo ((is_array($_tmp=$this->_tpl_vars['player']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['player']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span></td>
                                <td><?php echo smarty_function_counter(array(), $this);?>
</td>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['player']['Classification'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                            </tr>
                            
                            
                        <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['nump'] < 1): ?><tr class="filler"><td>-</td></tr><?php endif; ?>
                            <?php if ($this->_tpl_vars['nump'] < 2): ?><tr class="filler"><td>-</td></tr><?php endif; ?>
                            <?php if ($this->_tpl_vars['nump'] < 3): ?><tr class="filler"><td>-</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                
            </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<br style="clear: both; margin: 16px;" />
<hr />
<div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#14}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#14}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#15}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#15}'; endif;?>
" />
        <p><input class="all" type="checkbox" name="done" <?php if ($this->_tpl_vars['round']->groupsFinished !== null): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#16}'; endif;echo translate_smarty(array('id' => 'groups_finished'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#16}'; endif;?>
</p>
    </div>
</form>

<script type="text/javascript">
//<![CDATA[

var retag_error = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#17}'; endif;echo translate_smarty(array('id' => 'error_cant_tag_another'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#17}'; endif;?>
";
var tag_type_error = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#18}'; endif;echo translate_smarty(array('id' => 'error_cant_tag_different_type'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#18}'; endif;?>
";
var move_tagged_object = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#19}'; endif;echo translate_smarty(array('id' => 'move_tagged_object_here'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#19}'; endif;?>
";
var not_between_sections = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#20}'; endif;echo translate_smarty(array('id' => 'error_cant_move_between_sections'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#20}'; endif;?>
";
var change_hole_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:3bfe3c676f709288a2325bc7a2416eb8#21}'; endif;echo translate_smarty(array('id' => 'change_hole_prompt'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:3bfe3c676f709288a2325bc7a2416eb8#21}'; endif;?>
";
var locked = <?php if ($this->_tpl_vars['locked']): ?>true<?php else: ?>false<?php endif; ?>;

<?php echo '


var ignoreTagAttempt = false;
var tagged_group = null;
var beingDragged = null;
var tagged_people = new Array();

$(document).ready(function() {
    $("#reorg").click(redoColumns);
    $("#reba").click(rebalanceGroups);    
    redoColumns();
    
     $(".all").click(synchAll);
    
    
});


// Duplicated checkbox synchronization
function synchAll() {
    var c = this.checked;
    $(".all").each(function() {
        this.checked = c;
    });
}

// Renenerates the columns
function redoColumns() { 
    $(".groupman").each(function(gmind, gm) {
        if (tagged_group) untag_group();
        var items = $(this).find("li").get();
        $(this).find("ul").remove();
        
        
        var cols = parseInt($("#cols").get(0).value);
        var percolumn = Math.ceil(items.length / cols);
        var elemind = 0;
        
        for (var ind = 0; ind < cols; ++ind) {
            var list = document.createElement("ul");
            list.className = "oddrows grouplist";
            if (ind != 0) list.className += " needs_splitter";
            
            for (var rowind = 0; rowind < percolumn; ++rowind) {            
                if (elemind == items.length) break;
                list.appendChild(items[elemind++]);
            }
            
            gm.appendChild(list);
        }        
        
    });
    reinit();
}

// Attaches event handlers
function reinit() {  
   if (locked) return;
   $(".tag_group").click(function(a) {
        if (tagged_people.length != 0) {
            alert(tag_type_error);
        }
        else if (this == tagged_group) {
            untag_group();
        } else if (tagged_group == null) {
            tag_group(this);        
        } else {
            alert(retag_error);
        }
 
    });
   
   $(".tag_person").click(function(a) {
        if (tagged_group != null) {
            alert(tag_type_error);
        }
        else {
            tagOrUntagPerson(this);
        
        }
 
    });
   
   $(".tag_person").draggable({
        addClasses: false,
        containment: \'#content\',
        revert: true,
        revertDuration: 0,        
        zIndex: 200,
        helper: \'clone\',
        scroll: true,
        start: function(e, ui)  { ui.helper.addClass("beingDragged"); beingDragged = this; },
        stop: function(e, ui)  { ui.helper.removeClass("beingDragged"); },
        opacity: 0.8
        
    });
   
   $(".toplist").draggable({
        addClasses: false,
        containment: \'#content\',
         revert: true,
         revertDuration: 0,
        scroll: true,
        helper: \'clone\',
        zIndex: 200,
        start: function()  { $(this).addClass("beingDragged"); beingDragged = this; },
        stop: function()  { $(this).removeClass("beingDragged"); },
        opacity: 0.8
        
    });
   $(".toplist").droppable(
    {
        addClasses: false,
        hoverClass: \'droponme\',
        
        drop: dropped
    });
   
   $(".change_hole").click(changeHole);
   
   
}

// Change hole for group
function changeHole(e) {
    var base = this.parentNode.parentNode;
    var hidden = $(base).find(".holenum").get(0);
    var dn = $(base).find(".dispname").get(0);
    
    if (e) e.preventDefault();
    
    var newhole = prompt(change_hole_text, dn.textContent || dn.innerText);
    var hind = parseInt(newhole);
    if (hind) {
        hidden.value = "h" + hind;
        $(dn).empty();
        dn.appendChild(document.createTextNode(hind));
    }
    
    return false;
    
}


function tagOrUntagPerson(tr) {
    if (ignoreTagAttempt) {
        ignoreTagAttempt = false;
        return;
    }
    for (var ind = 0; ind < tagged_people.length; ++ind) {
        if (tagged_people[ind] == tr) {
            $(tr).removeClass(\'taggedp\');
            tagged_people.splice(ind, 1);
            if (tagged_people.length == 0) $(".moveToContainer").remove();
            return;
        }
    }
    
    tagged_people.push(tr);
    $(tr).addClass("taggedp");
    
    if (tagged_people.length == 1) {
        $(tr).closest(".groupman").find(".tag_group").each(function(index, item) {        
        var text = document.createTextNode(move_tagged_object);
        var button = document.createElement("button");
        var div = document.createElement("div");
        div.appendChild(button);
        div.className = "moveToContainer";
        button.appendChild(text);
        $(button).click(moveTaggedPeople);
        item.appendChild(div);
    });
    }
    
}

var droppedObj = null;
function dropped() {
    
    droppedObj = this;
    ignoreTagAttempt = true;
    
    setTimeout(dropped2, 150);
}

// Has to be done with a bit of delay after dragging or things might
// get weird
function dropped2() {
    
    if (beingDragged.tagName && beingDragged.tagName.match(/tr/i)) {
        for (var ind = 0; ind < tagged_people.length; ++ind) {
        
            var tr = tagged_people[ind];
            $(tr).removeClass(\'taggedp\');            
        }
        tagged_people = new Array();
        tagged_people.push(beingDragged);
        moveTaggedPeople(null, droppedObj);
        
    } else {
        tagged_group = $(beingDragged).find(".tag_group").get(0);
        
        if (tagged_group) moveTaggedGroup(null, droppedObj);
        
    }
    ignoreTagAttempt = true;
    tagged_group = null;
    tagged_people = new Array();
}

function tag_group(group) {
    if (ignoreTagAttempt) {
        ignoreTagAttempt = false;        
        return;
    }
    
    tagged_group = group;
    $(group).parent().addClass("tagged");
    
    $(group).closest(".groupman").find(".tag_group").each(function(index, item) {        
        var text = document.createTextNode(move_tagged_object);
        var button = document.createElement("button");
        var div = document.createElement("div");
        div.appendChild(button);
        div.className = "moveToContainer";
        button.appendChild(text);
        $(button).click(moveTaggedGroupButton);
        item.appendChild(div);
    });
    
    
}

function moveTaggedGroupButton(e) {
    if (e) e.preventDefault();
    moveTaggedGroup(null, this);
    return false;
}

function moveTaggedPeople(ignored, moveTarget) {
    ignoreTagAttempt = true;
    var target, chosen, tagged_id;    
    
    if (moveTarget == undefined) {
        
        target = $(this).closest("li");
    } else {
        
        target = $(moveTarget);        
    }
    
    var tbody = target.find(".innertable tbody").get(0);
    
    $(tbody).find(".filler").remove();
    for (var ind = 0; ind < tagged_people.length; ++ind) {
        
        var tr = tagged_people[ind];
        sourceTable = tr.parentNode;
        $(tr).removeClass(\'taggedp\');
        tbody.appendChild(tr);
        lockRow(tr);
        ensureTablePadding(sourceTable);
    }
    
    ensureTablePadding(tbody);
    
    tagged_people = new Array();
    $(".moveToContainer").remove();
    
    
}

function lockRow(row) {
    var td = $(row).find("td:eq(0) span");
    var text = td.text();
    if (text.substring(0, 1) == "*") return;
    td.empty();
    td = td.get(0);
    td.appendChild(document.createTextNode("*" + text));
}

// Not really necessary with the new layout, but this makes sure there\'s
// either 3 people or dashes as placeholders in each group
function ensureTablePadding(tbody) {
    
    while ($(tbody).children("tr").length < 3) {
        var text = document.createTextNode("-");
        var td = document.createElement("td");
        td.appendChild(text);
        var tr = document.createElement("tr");
        tr.appendChild(td);
        tr.className = "filler";
        tbody.appendChild(tr);
    }
}

function moveTaggedGroup(ignored, moveTarget) {
    ignoreTagAttempt = true;
    var target, chosen, tagged_id;
        
    
    var local_tagged_group = tagged_group;
    tagged_id = local_tagged_group.innerText || local_tagged_group.textContent;
    
    
    
    $(tagged_group).addClass("persistent_tag");
        
    var chosenText;
        
    if (!moveTarget) {                
        target = $(this).closest("li");
        chosen = this.parentNode.previousSibling
        chosenText = chosen.innerText || chosen.textContent;
    } else {        
        target = $(moveTarget);
        chosen = $(moveTarget).find(".tag_group").get(0);
        if (!chosen) {
            target = $(moveTarget).closest("li").get(0);
            chosen = $(moveTarget).closest(".tag_group").get(0);
        }
        chosenText = chosen.innerText || chosen.textContent;
    }
    
    
    var sourceContent = $(tagged_group).parent().find(".tcon table").get(0);

    var sourceGm = $(tagged_group).closest(".groupman").get(0);
    var targetGm = $(target).closest(".groupman").get(0);
    
    if (sourceGm != targetGm) {
        alert(not_between_sections);
        untag_group();
        return false;
    }
    
    if (chosenText == tagged_id) {
        untag_group();
        return false;
    }
    
    
    
    
    
    var colobj = $("#cols").get(0);
    var coltext = colobj.value;
    colobj.value = "1";
    
    
    $("#reorg").click();
    chosen = chosen.textContent || chosen.innerText;
   
    tagged_id = local_tagged_group.innerText || local_tagged_group.textContent;
    
    //alert(local_tagged_group.textContent);
    
    var list = $(".persistent_tag").closest(".grouplist");
    
    var last = null;
    
    var foundtarget = false;
    var foundsource = false;
    
    //var replaceTargetContent = false;
    
    
    
    var targetTcon = $(target).find(".tcon");
    
    
          
    list.find("li").each(function(index, item) {
        
        if (foundtarget && foundsource) {
            
            
        } else {
            
            var textobj = $(this).find(".tag_group").get(0);
            var text = textobj.innerText || textobj.textContent;
        
            if (text == tagged_id) {
                
                foundsource = true;
                var tcon = $(this).find(".tcon");
                if (foundtarget) {                                        
                    tcon.empty();
                    tcon.get(0).appendChild(last.get(0));
                } else {
                    last = tcon;                   
                }
            } else if (text == chosen) {
                
                foundtarget = true;
                if (foundsource) {
                    
                    last.empty();
                    last.get(0).appendChild($(this).find(".tcon table").get(0));
                    
                } else {
                    last = $(this).find(".tcon table");
                }
            } else if (foundsource) {
                
                // source, but no target
                last.empty();
                var tcon = $(this).find(".tcon");
                var table = $(tcon).find("table");
                last.get(0).appendChild(table.get(0));
                last = tcon;
            
            } else if (foundtarget) {
                
                var tcon = $(this).find(".tcon");
                var mytable = $(tcon).find("table");
                
                tcon.empty();
                tcon.get(0).appendChild(last.get(0));
                last = mytable;
            } else {
                //alert(\'irrelevant\');
                
            }
            
            
        }
        
        
    });
    
    
    targetTcon.empty();
    targetTcon.get(0).appendChild(sourceContent);
    
    
    $(tagged_group).removeClass("persistent_tag");
    
    colobj.value = coltext;
    $("#reorg").click();
    
    
}

function untag_group() {
    
    $(tagged_group).parent().removeClass("tagged");
    tagged_group = null;
    
    $(".moveToContainer").remove();
}

function rebalanceGroups(e) {
    if (e) e.preventDefault();
    $(".groupman").each(function(){
       
       $(".tcon").each(function() {
        var trs = $(this).find("tr").get();
        var body = $(this).find("tbody").get(0);
        quick_sort(trs, personComparison);
        for (var i = 0; i < trs.length; ++i) {
            body.appendChild(trs[i]);
        }
       });
       
        var trs = $(this).find(".tcon tr");
        
        
        
        
        var validPeople = trs.filter(function() {
            
            return $(this).find("td").length == 3;
        });
        
        
        var trs = trs.get();
        
        
        var groupSizes = GetGroupSizes(validPeople.length, $(this).find(".tcon").length);
        var trind = 0;
        for (var groupInd = 0; groupInd < groupSizes.length; ++groupInd ) {
            var numPeople = groupSizes[groupInd];
            var body = $(this).find(".tcon tbody").get(groupInd);
            var locked = getNumLockedIn(body);
            
            for (pInd = 0; pInd < numPeople - locked; ++pInd) {
                var tr;
                while (true) {
                    tr = trs[trind++];
                    
                    if (!tr) return;
                    if ($(tr).find("td").length == 3) {
                        if ($(tr).find("td:eq(0) span").text().substring(0, 1) == "*") continue;
                        break;
                    } else {                        
                        $(tr).remove();
                    }                    
                }
                
                body.appendChild(tr);
            }
        }
        
        while (trind < trs.length - 1) {
            if ($(trs[trind]).find("td").length != 3) $(trs[trind]).remove();
            ++trind;
        }
       
    });
    return false;
    
}

function getNumLockedIn(tbody) {
    var locked = 0;
    $(tbody).find("tr").each(function() {
        
       if ($(this).find("td:eq(0) span").text().substring(0, 1) == "*") locked++; 
    });
    return locked;
}

function GetGroupSizes(people, maxGroups) {
    var sizes = new Array();
    sizes[3] = 0;
    sizes[4] = 0;
    sizes[5] = 0;
    
    if (people == 6) {
        sizes[3] = 2;
    } else if (people == 9) {
        sizes[4] = 1;
        sizes[5] = 1;    
    } else {
        if (people <= 5) {
            sizes[people] = 1;
        } else {
            four = Math.floor(people / 4);
            three = people % 4 ? 1 : 0;
            
            while (four * 4 + three * 3 != people) {
                if (four * 4 + three * 3 > people) {
                    four--;
                } else {
                    three++;
                }
            }
            sizes[4] = four;
            sizes[3] = three;
        }
    }
    
    var groups = new Array();
    for (var size = 1; size <= 5; ++size) {
        if (!sizes[size]) continue;
        var numGroups = sizes[size];
        while (numGroups--) {
            if (groups.length != maxGroups) {
                groups.push(size);
            }  else {
                groups[groups.length - 1] += size;
            }
        }
    }
    
    
    
    return groups;
}

function personComparison(a, b) {
    var tdsa = $(a).find("td");
    var tdsb = $(b).find("td");
    
    if (tdsa.length != tdsb.length) {
        if (tdsa.length > tdsb.length) return -1;
        return 1;    
    }
    
    if (tdsa.length != 3) return 0;
    var tda = tdsa.get(1);
    var tdb = tdsb.get(1);
    
    var av = parseInt(tda.textContent || tda.innerText);
    var bv = parseInt(tdb.textContent || tdb.innerText);
    
    if (av < bv) return -1;
    if (av == bv) return 0;
    return 1;
}

'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>