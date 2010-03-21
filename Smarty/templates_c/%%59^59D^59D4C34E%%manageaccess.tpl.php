<?php /* Smarty version 2.6.26, created on 2010-02-14 11:37:57
         compiled from manageaccess.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageaccess.tpl', 22, false),array('function', 'url', 'manageaccess.tpl', 25, false),array('function', 'initializeGetFormFields', 'manageaccess.tpl', 26, false),array('function', 'sortheading', 'manageaccess.tpl', 40, false),array('modifier', 'escape', 'manageaccess.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%59^59D^59D4C34E%%manageaccess.tpl.inc'] = '29a431574925ff21e150df0423957ffc'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#0}'; endif;echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="GET" class="usersform" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#1}'; endif;echo url_smarty(array('page' => 'manageaccess'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#1}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#2}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#2}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#3}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#3}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input id="searchField" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#4}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#4}'; endif;?>
" />
    </div>    
</form>

<div class="SearchStatus" />
<form method="POST">
    <p style="clear: both;"><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#5}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#5}'; endif;?>
" /></p>
    <input type="hidden" name="formid" value="manage_access" />
    <table id="userTable" class="hilightrows">
       <tr>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#6}'; endif;echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#6}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#7}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#7}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#8}'; endif;echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#8}'; endif;?>
</th>
          <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#9}'; endif;echo sortheading_smarty(array('field' => 1,'id' => 'user_ban','sortType' => 'checkboxchecked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#9}'; endif;?>
</th>
                 </tr>
        
            
       <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
          <?php $this->assign('userid', $this->_tpl_vars['user']['user']->id); ?>          
         <tr>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#10}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#10}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->fullname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
            
             <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
             <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#11}'; endif;echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#11}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['user']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
             <td>
                <input type="hidden" name="oldban_<?php echo $this->_tpl_vars['userid']; ?>
" value="<?php echo $this->_tpl_vars['user']['banned']; ?>
" />
                <input type="checkbox" name="ban_<?php echo $this->_tpl_vars['userid']; ?>
" <?php if ($this->_tpl_vars['user']['banned']): ?>checked="1"<?php endif; ?> />
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#12}'; endif;echo translate_smarty(array('id' => 'ban'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#12}'; endif;?>

             </td>
                     </tr>
       <?php endforeach; endif; unset($_from); ?>     
    </table>
    <p style="clear: both;">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#13}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#13}'; endif;?>
" />
        <input name="cancel" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#14}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#14}'; endif;?>
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
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29a431574925ff21e150df0423957ffc#15}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29a431574925ff21e150df0423957ffc#15}'; endif;?>
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