<?php /* Smarty version 2.6.26, created on 2010-03-20 09:55:44
         compiled from eventfees.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventfees.tpl', 22, false),array('function', 'url', 'eventfees.tpl', 29, false),array('function', 'initializeGetFormFields', 'eventfees.tpl', 30, false),array('function', 'sortheading', 'eventfees.tpl', 48, false),array('modifier', 'escape', 'eventfees.tpl', 33, false),array('modifier', 'date_format', 'eventfees.tpl', 83, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C5^C55^C5521537%%eventfees.tpl.inc'] = 'b41e78105872849554d041ee540a9b00'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#0}'; endif;echo translate_smarty(array('id' => 'eventfees_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "support/eventlockhelper.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><button id="toggle_submenu"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#1}'; endif;echo translate_smarty(array('id' => 'toggle_menu'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#1}'; endif;?>
</button></p>

<form method="get" class="usersform searcharea" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#2}'; endif;echo url_smarty(array('page' => 'eventfees','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#2}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#3}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#3}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#4}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#4}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#5}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#5}'; endif;?>
" />
    </div>
    <br style="clear: both" />
</form>


<div class="SearchStatus" />
<form method="post">
    <p style="clear: both;"><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#6}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#6}'; endif;?>
" /></p>
    <p><input class="all" type="checkbox" name="remind_all" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#7}'; endif;echo translate_smarty(array('id' => 'remind_all'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#7}'; endif;?>
</p>
    <input type="hidden" name="formid" value="event_fees" />
    <table id="userTable" class="hilightrows oddrows">
       <tr>
        <th>#</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#8}'; endif;echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#8}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#9}'; endif;echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#9}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#10}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#10}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#11}'; endif;echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#11}'; endif;?>
</th>
          
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#12}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'users_eventfees','sortType' => 'checkboxchecked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#12}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#13}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'eventfee_remind','sortType' => 'checkboxchecked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#13}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#14}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'date','sortType' => 'date'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#14}'; endif;?>
</th>          
       </tr>
        
       <?php $this->assign('i', 1); ?>     
       <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
          <?php $this->assign('userid', $this->_tpl_vars['user']['user']->id); ?>
          <?php $this->assign('partid', $this->_tpl_vars['user']['participationId']); ?>
         <tr>
            <td><?php echo $this->_tpl_vars['i']++; ?>
</td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#15}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#15}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#16}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#16}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            
             <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
             <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#17}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#17}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
             
             <td>
                <input type="hidden" name="oldfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['partid']; ?>
" value="<?php echo $this->_tpl_vars['user']['eventFeePaid']; ?>
" />
                <input type="checkbox" class="payment" name="newfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['partid']; ?>
" <?php if ($this->_tpl_vars['user']['eventFeePaid'] !== null): ?>checked="checked"<?php endif; ?> />
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#18}'; endif;echo translate_smarty(array('id' => 'fee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#18}'; endif;?>

             </td>
            <td>
                <input type="checkbox" <?php if ($this->_tpl_vars['user']['eventFeePaid'] !== null): ?>disabled="disabled"<?php endif; ?> class="remind" name="remind_<?php echo $this->_tpl_vars['userid']; ?>
" />
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#19}'; endif;echo translate_smarty(array('id' => 'remind'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#19}'; endif;?>

            </td>
            <td>
                <?php if ($this->_tpl_vars['user']['eventFeePaid'] !== null): ?>
                 <?php $this->assign('paid', $this->_tpl_vars['paid']+1); ?>   
                    <input type="hidden" value="<?php echo $this->_tpl_vars['user']['eventFeePaid']; ?>
" />
                    <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['eventFeePaid'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('date', ob_get_contents());ob_end_clean(); ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#20}'; endif;echo translate_smarty(array('id' => 'payment_date','date' => $this->_tpl_vars['date']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#20}'; endif;?>

                <?php else: ?>
                <?php $this->assign('not_paid', $this->_tpl_vars['not_paid']+1); ?>   
                <input type="hidden" value="<?php echo $this->_tpl_vars['user']['signupTimestamp']; ?>
" />
                    <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['signupTimestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('date', ob_get_contents());ob_end_clean(); ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#21}'; endif;echo translate_smarty(array('id' => 'signup_date','date' => $this->_tpl_vars['date']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#21}'; endif;?>

                    
                <?php endif; ?>
             </td>
         </tr>
       <?php endforeach; endif; unset($_from); ?>     
    </table>
    <p><input class="all" type="checkbox" name="remind_all" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#22}'; endif;echo translate_smarty(array('id' => 'remind_all'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#22}'; endif;?>
</p>
    <p style="clear: both;">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#23}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#23}'; endif;?>
" />
        <input name="cancel" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#24}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#24}'; endif;?>
" />
    </p>
</form>
<div class="SearchStatus" />
<p>Maksettu: <?php echo $this->_tpl_vars['paid']; ?>
 / <?php echo $this->_tpl_vars['paid']+$this->_tpl_vars['not_paid']; ?>
</p>


<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    TableSearch(document.getElementById(\'searchField\'), document.getElementById(\'userTable\'),
                '; ?>
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b41e78105872849554d041ee540a9b00#25}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b41e78105872849554d041ee540a9b00#25}'; endif;?>
"<?php echo '
                );   
    $($(".SortHeading").get(0)).click();
    $("#toggle_submenu").click(toggleSubmenu);
    
    SortDoneCallback = attachInputEvents;
    attachInputEvents();
    
    $(".all").click(synchAll)
    
});

function synchAll() {
    var c = this.checked;
    $(".all").each(function() {
        this.checked = c;
    });
}

function attachInputEvents() {
    $(".payment").click(adjustRemind)
}

function adjustRemind() {
    var remind = $(this).parent().next("td").find(".remind").get(0);
    
    if (this.checked) {
        remind.disabled = true;
        remind.checked = false;
    } else {
        remind.disabled = false;
    }
}

function toggleSubmenu() {
    $("#submenucontainer").toggle();
}


'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>