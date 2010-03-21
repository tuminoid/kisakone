<?php /* Smarty version 2.6.26, created on 2010-02-13 13:59:49
         compiled from managefees.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managefees.tpl', 22, false),array('function', 'url', 'managefees.tpl', 25, false),array('function', 'initializeGetFormFields', 'managefees.tpl', 26, false),array('function', 'sortheading', 'managefees.tpl', 40, false),array('modifier', 'escape', 'managefees.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%1D^1D6^1D602AEE%%managefees.tpl.inc'] = '96f2ab93f2f223ee8b92311953537827'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#0}'; endif;echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="GET" class="usersform" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#1}'; endif;echo url_smarty(array('page' => 'managefees'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#1}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#2}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#2}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#3}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#3}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input id="searchField" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#4}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#4}'; endif;?>
" />
    </div>    
</form>

<div class="SearchStatus" />
<form method="POST">
    <p style="clear: both;"><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#5}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#5}'; endif;?>
" /></p>
    <input type="hidden" name="formid" value="manage_fees" />
    <table id="userTable" class="hilightrows">
       <tr>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#6}'; endif;echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#6}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#7}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#7}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#8}'; endif;echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#8}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#9}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'user_licensefee','sortType' => 'checkboxchecked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#9}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#10}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'user_membershipfee','sortType' => 'checkboxchecked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#10}'; endif;?>
</th>
                 </tr>
        
            
       <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
          <?php $this->assign('userid', $this->_tpl_vars['user']['user']->id); ?>          
         <tr>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#11}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#11}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->fullname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            
             <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
             <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#12}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#12}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
             <td>
                <?php $_from = $this->_tpl_vars['user']['licensefees']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['payment']):
?>
                    <input type="hidden" name="oldlfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['year']; ?>
" value="<?php echo $this->_tpl_vars['payment']; ?>
" />
                    <input type="checkbox" name="newlfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['year']; ?>
" <?php if ($this->_tpl_vars['payment']): ?>checked="1"<?php endif; ?> />
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#13}'; endif;echo translate_smarty(array('id' => 'fee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#13}'; endif;?>
 <?php echo $this->_tpl_vars['year']; ?>
<br />
                <?php endforeach; endif; unset($_from); ?>
             </td>
            <td>
                <?php $_from = $this->_tpl_vars['user']['membershipfees']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['payment']):
?>
                    <input type="hidden" name="oldmfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['year']; ?>
" value="<?php echo $this->_tpl_vars['payment']; ?>
" />
                    <input type="checkbox" name="newmfee_<?php echo $this->_tpl_vars['userid']; ?>
_<?php echo $this->_tpl_vars['year']; ?>
" <?php if ($this->_tpl_vars['payment']): ?>checked="1"<?php endif; ?> />
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#14}'; endif;echo translate_smarty(array('id' => 'fee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#14}'; endif;?>
 <?php echo $this->_tpl_vars['year']; ?>
<br />
                <?php endforeach; endif; unset($_from); ?>
             </td>
                     </tr>
       <?php endforeach; endif; unset($_from); ?>     
    </table>
    <p style="clear: both;">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#15}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#15}'; endif;?>
" />
        <input name="cancel" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#16}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#16}'; endif;?>
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
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:96f2ab93f2f223ee8b92311953537827#17}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:96f2ab93f2f223ee8b92311953537827#17}'; endif;?>
"<?php echo '
                );   
    $($(".SortHeading").get(0)).click();
    
});



'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>