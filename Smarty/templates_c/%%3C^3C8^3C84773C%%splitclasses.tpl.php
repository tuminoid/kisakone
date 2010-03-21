<?php /* Smarty version 2.6.26, created on 2010-02-17 19:13:16
         compiled from splitclasses.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'splitclasses.tpl', 22, false),array('function', 'initializeGetFormFields', 'splitclasses.tpl', 107, false),array('function', 'counter', 'splitclasses.tpl', 151, false),array('modifier', 'escape', 'splitclasses.tpl', 138, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%3C^3C8^3C84773C%%splitclasses.tpl.inc'] = 'cc48fb93c7a5dcbb172f0c287f2fd2b3'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#0}'; endif;echo translate_smarty(array('id' => 'splitclasses_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#0}'; endif;?>

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
        float: left;
        padding: 16px;
        margin: 8px;
    }
    
    h2 {
        clear: both;
    }
    
    .name {
        min-width: 120px;
        display: inline-block;
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



<?php if ($this->_tpl_vars['suggestRegeneration']): ?>
    <div class="error">
        <form method="get">
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#1}'; endif;echo initializeGetFormFields_Smarty(array('regenerate' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#1}'; endif;?>

            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#2}'; endif;echo translate_smarty(array('id' => 'regenerate_section_text_2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#2}'; endif;?>
</p>
            <p><input name="regenerate" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#3}'; endif;echo translate_smarty(array('id' => 'regenerate_sections'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#3}'; endif;?>
" /></p>
        </form>
    </div>
<?php else: ?>
    <div class="searcharea">
        <form method="get">
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#4}'; endif;echo initializeGetFormFields_Smarty(array('regenerate' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#4}'; endif;?>

            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#5}'; endif;echo translate_smarty(array('id' => 'regenerate_section_text_1'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#5}'; endif;?>
</p>
            <p><input name="regenerate"  type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#6}'; endif;echo translate_smarty(array('id' => 'regenerate_sections'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#6}'; endif;?>
" /></p>
        </form>
    </div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="formid" value="split_classes" />
    
    <div  class="buttonarea">
        <p style="float: right; max-width: 200px;"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#7}'; endif;echo translate_smarty(array('id' => 'split_classes_quickhelp'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#7}'; endif;?>
</p>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#8}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#8}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#9}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#9}'; endif;?>
" />
    </div>
    
    

<?php $this->assign('parentid', 'undefined'); ?>
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['section']):
?>    
    <?php if ($this->_tpl_vars['section']->classification !== $this->_tpl_vars['parentid']): ?>
        <?php $this->assign('parentid', $this->_tpl_vars['section']->classification); ?>
        <div></div>
        <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['section']->GetClassName())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
        <?php $this->assign('first', true); ?>
    <?php endif; ?>
                
            <div class="subclass cid<?php echo $this->_tpl_vars['section']->classification; ?>
" id="c_<?php echo $this->_tpl_vars['section']->id; ?>
">
                <input name="cname_<?php echo $this->_tpl_vars['section']->id; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['section']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                
                <ul>
       
                    <?php $_from = $this->_tpl_vars['section']->GetPlayers(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['player']):
?>
                        <li><input type="hidden" name="p<?php echo $this->_tpl_vars['player']['PlayerId']; ?>
" value="c_<?php echo $this->_tpl_vars['section']->id; ?>
" />
                            <span class="name"><?php echo ((is_array($_tmp=$this->_tpl_vars['player']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['player']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
, </span>
                            <span class="pdga"><?php echo $this->_tpl_vars['player']['PDGANumber']; ?>
</span><?php if ($this->_tpl_vars['firstRound']): ?>,
                            <span class="class"><?php echo ((is_array($_tmp=$this->_tpl_vars['player']['Classification'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span><?php else: ?>, #<?php echo smarty_function_counter(array(), $this);?>
<?php endif; ?></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
                <button class="splitButton splitBase_<?php echo $this->_tpl_vars['section']->classification; ?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#10}'; endif;echo translate_smarty(array('id' => 'split'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#10}'; endif;?>
</button>
                <?php if (! $this->_tpl_vars['first']): ?>
                    <button class="joinButton splitBase_<?php echo $this->_tpl_vars['section']->classification; ?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#11}'; endif;echo translate_smarty(array('id' => 'combine'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#11}'; endif;?>
</button>
                <?php endif; ?>
            </div>                    
                <?php $this->assign('first', false); ?>
<?php endforeach; endif; unset($_from); ?>
<div></div>

    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#12}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#12}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#13}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#13}'; endif;?>
" />
    </div>

</form>

<script type="text/javascript">
//<![CDATA[

var locked = <?php if ($this->_tpl_vars['locked']): ?>true<?php else: ?>false<?php endif; ?>;

<?php echo '


var beingDragged = null;

var newClassIndex = 1;


$("document").ready(function(){
    reInit();
    $(".splitButton").click(doSplit);
    $(".joinButton").click(doJoin);
});

function reInit() {
    if (locked) return;
   $(".subclass li").draggable({
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
   
   
   
   $(".subclass").droppable(
    {
        addClasses: false,
        hoverClass: \'droponme\',
        
        drop: dropped
    });
   
 
}

function getBaseId(button) {
    var cn = button.className;
    var s = cn.split(\'_\');
    return s[1];
}

function doSplit() {
    var baseId = getBaseId(this);

    //<input name="cname_{$class->id}" value="{$class->name|escape}" />
    var div = document.createElement(\'div\');
    div.className = this.parentNode.className;
    
    
    var h3 = document.createElement(\'input\');
    h3.type = "text";
    var myid = "c_n" + (++newClassIndex);
    h3.name = "cname_" + myid.substring(2);

    div.id = myid;
    
    
    var splitName = prompt("'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#14}'; endif;echo translate_smarty(array('id' => 'enter_split_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#14}'; endif;?>
<?php echo '");
    if (splitName == undefined) return false;
    if (!splitName) splitName = "'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#15}'; endif;echo translate_smarty(array('id' => 'new_split_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#15}'; endif;?>
<?php echo '";
    
    h3.value = splitName;
    
    div.appendChild(h3);
    
    var baseInput = document.createElement(\'input\');
    
    baseInput.type = "hidden";
    baseInput.name = "base_" + myid;
    baseInput.value = baseId;
    
    div.appendChild(baseInput);
    
    var list = document.createElement(\'ul\');
    div.appendChild(list);
    
    var button = document.createElement(\'button\');
    button.appendChild(document.createTextNode("'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#16}'; endif;echo translate_smarty(array('id' => 'split'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#16}'; endif;?>
<?php echo '"));
    button.className = "splitButton splitBase_" + baseId;
    
    div.appendChild(button);
    
    var joinButton = document.createElement(\'button\');
    joinButton.appendChild(document.createTextNode("'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#17}'; endif;echo translate_smarty(array('id' => 'combine'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#17}'; endif;?>
<?php echo '"));
    div.appendChild(joinButton);
    
    var myList = this.previousSibling;
    while (!myList.tagName || ! myList.tagName.match(/ul/i)) myList = myList.previousSibling;
    
    moveHalf(myList, list, myid);
    
    this.parentNode.parentNode.insertBefore(div, this.parentNode.nextSibling);
        
    $(button).click(doSplit);
    $(joinButton).click(doJoin);
    reInit();
    
    return false;
}

function doJoin() {
    var myList = this.previousSibling;
    while (!myList.tagName || !myList.tagName.match(/ul/i)) myList = myList.previousSibling;
    
    var prevContainer = this.parentNode.previousSibling;
    while (!prevContainer.tagName || !prevContainer.tagName.match(/div/i)) prevContainer = prevContainer.previousSibling;
    var prevList = prevContainer.firstChild;
    
    while (!prevList.tagName || !prevList.tagName.match(/ul/i)) prevList = prevList.nextSibling;
    
    while (myList.childNodes.length != 0) {
        if (!myList.firstChild.tagName ||  !myList.firstChild.tagName.match(/li/i)) {
            myList.removeChild(myList.firstChild);
        } else {
            setId(myList.firstChild, prevContainer.id);
            prevList.appendChild(myList.firstChild);            
        }
    }
    
    this.parentNode.parentNode.removeChild(this.parentNode);
}

function moveHalf(from, to, newId) {
    var count = 0;
    for (var i in from.childNodes) if (from.childNodes[i].tagName && from.childNodes[i].tagName.match (/li/i)) count++;
    
    if (count < 2) return;
    var skip = Math.ceil(count / 2);
    
    var toMove = new Array();
    
    for (var i in from.childNodes) {
        if (!from.childNodes[i].tagName || !from.childNodes[i].tagName.match(/li/i)) continue;
        if (skip) skip--;
        else {
            toMove.push(from.childNodes[i]);
        }
        
    }
    
    for (var i = 0; i < toMove.length; ++i) {
        setId(toMove[i], newId);
        to.appendChild(toMove[i]);
    }
    
}

function dropped() {
    
    var srcPanel = beingDragged.parentNode.parentNode;
    if (srcPanel == this) return;
    
    if (this.className !=  srcPanel.className) {
        alert(this.className + " -- " + srcPanel.className);
        alert("'; ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#18}'; endif;echo translate_smarty(array('id' => 'cant_move_between_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:cc48fb93c7a5dcbb172f0c287f2fd2b3#18}'; endif;?>
<?php echo '");
        return;
    }
    
    var myList = this.firstChild;
    while (!myList.tagName || !myList.tagName.match(/ul/i)) myList = myList.nextSibling;
    
    if (firstBeforeLater(srcPanel, this)) {
        if (myList.firstChild) {
            myList.insertBefore(beingDragged, myList.firstChild);            
        } else {
            myList.appendChild(beingDragged);
        }
    } else {
        myList.appendChild(beingDragged);
    }
    setId(beingDragged, this.id);
  
}

function setId(li, id) {
    var c = li.firstChild;
    while (!c.tagName || !c.tagName.match(/input/i) ) c = c.nextSibling;
    c.value = id;
}

function firstBeforeLater(first, later) {
    var node = first.nextSibling;
    while (node != null) {
        if (node == later) return true;
        node = node.nextSibling;
    }
    return false;
}
'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
