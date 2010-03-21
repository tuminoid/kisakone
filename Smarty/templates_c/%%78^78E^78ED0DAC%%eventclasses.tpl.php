<?php /* Smarty version 2.6.26, created on 2010-02-18 19:57:56
         compiled from eventclasses.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventclasses.tpl', 22, false),array('function', 'url', 'eventclasses.tpl', 32, false),array('function', 'initializeGetFormFields', 'eventclasses.tpl', 33, false),array('function', 'sortheading', 'eventclasses.tpl', 51, false),array('modifier', 'escape', 'eventclasses.tpl', 36, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%78^78E^78ED0DAC%%eventclasses.tpl.inc'] = 'd49157a30f5008add1403c2d4e685d7e'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#0}'; endif;echo translate_smarty(array('id' => 'eventfees_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "support/eventlockhelper.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><button id="toggle_submenu"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#1}'; endif;echo translate_smarty(array('id' => 'toggle_menu'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#1}'; endif;?>
</button></p>

<form method="get" class="usersform searcharea" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#2}'; endif;echo url_smarty(array('page' => 'eventclasses','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#2}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#3}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#3}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#4}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#4}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#5}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#5}'; endif;?>
" />
    </div>
    <br style="clear: both" />
</form>


<div class="SearchStatus" />
<form method="post">
    <p style="clear: both;"><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#6}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#6}'; endif;?>
" />
        <input name="cancel" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#7}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#7}'; endif;?>
" /></p>
    
    <input type="hidden" name="formid" value="event_classes" />
    <table id="userTable" class="hilightrows oddrows">
       <tr>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#8}'; endif;echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#8}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#9}'; endif;echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#9}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#10}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#10}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#11}'; endif;echo sortheading_smarty(array('field' => 'birthyear','id' => 'birthyear','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#11}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#12}'; endif;echo sortheading_smarty(array('field' => 'gender','id' => 'gender','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#12}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#13}'; endif;echo sortheading_smarty(array('field' => 'class','id' => 'class','sortType' => 'selectText'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#13}'; endif;?>
</th>
          
          
       </tr>
        
            
       <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
          <?php $this->assign('userid', $this->_tpl_vars['user']['user']->id); ?>
          <?php $this->assign('partid', $this->_tpl_vars['user']['participationId']); ?>
         <tr>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#14}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#14}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#15}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#15}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            
             <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
             <td><?php echo $this->_tpl_vars['user']['player']->birthyear; ?>
</td>             
             <td><?php if ($this->_tpl_vars['user']['player']->gender == 'M'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#16}'; endif;echo translate_smarty(array('id' => 'male'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#16}'; endif;?>
<?php else: ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#17}'; endif;echo translate_smarty(array('id' => 'female'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#17}'; endif;?>
<?php endif; ?></td>
             <td>
                <input type="hidden" name="init_<?php echo $this->_tpl_vars['user']['player']->id; ?>
" value="<?php echo $this->_tpl_vars['user']['classId']; ?>
" />
                <select name="class_<?php echo $this->_tpl_vars['user']['player']->id; ?>
"
                <?php $this->assign('userclass', $this->_tpl_vars['user']['classId']); ?>
                <?php if ($this->_tpl_vars['badClasses'][$this->_tpl_vars['userclass']]): ?>
                        class="bad_class"
                        <?php endif; ?>
                >
                    <?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class']):
?>
                    <?php $this->assign('cid', $this->_tpl_vars['class']->id); ?>
                    <?php if (! $this->_tpl_vars['badClasses'][$this->_tpl_vars['cid']]): ?>
                        <option value="<?php echo $this->_tpl_vars['class']->id; ?>
" <?php if ($this->_tpl_vars['user']['classId'] == $this->_tpl_vars['class']->id): ?>selected="selected"<?php endif; ?>>
                        <?php echo $this->_tpl_vars['class']->name; ?>

                        </option>
                    <?php elseif ($this->_tpl_vars['class']->id == $this->_tpl_vars['user']['classId']): ?>
                     <option value="<?php echo $this->_tpl_vars['class']->id; ?>
" <?php if ($this->_tpl_vars['user']['classId'] == $this->_tpl_vars['class']->id): ?>selected="selected"<?php endif; ?> class="bad_class">
                        <?php echo $this->_tpl_vars['class']->name; ?>

                        </option>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                    <option disabled="disabled">---------</option>
                    <option style="background-color: #FCC;" value="removeplayer"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#18}'; endif;echo translate_smarty(array('id' => 'remove_player_from_event'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#18}'; endif;?>
</option>
                </select>
                
             </td>
        
         </tr>
       <?php endforeach; endif; unset($_from); ?>     
    </table>
    
    <p style="clear: both;">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#19}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#19}'; endif;?>
" />
        <input name="cancel" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#20}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#20}'; endif;?>
" />
    </p>
</form>
<div class="SearchStatus" />

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    TableSearch(document.getElementById(\'searchField\'), document.getElementById(\'userTable\'),
                '; ?>
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d49157a30f5008add1403c2d4e685d7e#21}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d49157a30f5008add1403c2d4e685d7e#21}'; endif;?>
"<?php echo '
                );   
    $($(".SortHeading").get(0)).click();
    $("#toggle_submenu").click(toggleSubmenu);
    
    
    
    
    
    
});




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