<?php /* Smarty version 2.6.26, created on 2010-02-16 14:29:20
         compiled from users.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'users.tpl', 22, false),array('function', 'url', 'users.tpl', 25, false),array('function', 'initializeGetFormFields', 'users.tpl', 26, false),array('function', 'sortheading', 'users.tpl', 38, false),array('modifier', 'escape', 'users.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%27^27D^27DA1DD4%%users.tpl.inc'] = '4f646b42ef837d4ef57b94183fccefd8'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#0}'; endif;echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="get" class="usersform" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#1}'; endif;echo url_smarty(array('page' => 'users'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#1}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#2}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#2}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#3}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#3}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#4}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#4}'; endif;?>
" />
    </div>    
</form>
<hr style="clear: both;" />
<div class="SearchStatus" />

<table id="userTable">
   <tr>
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#5}'; endif;echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#5}'; endif;?>
</th>
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#6}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#6}'; endif;?>
</th>
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#7}'; endif;echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#7}'; endif;?>
</th>
      
   </tr>

   <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
      
      <?php $this->assign('player', $this->_tpl_vars['user']->GetPlayer()); ?>
      <?php if ($this->_tpl_vars['user']->username == null || strpos ( $this->_tpl_vars['user']->username , '/' ) !== false): ?>
        <?php ob_start(); ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#8}'; endif;echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['user']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#8}'; endif;?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('url', ob_get_contents());ob_end_clean(); ?>
        <?php else: ?>
        <?php ob_start(); ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#9}'; endif;echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['user']->username), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#9}'; endif;?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('url', ob_get_contents());ob_end_clean(); ?>
        <?php endif; ?>
      
     <tr>
        <td><a href="<?php echo $this->_tpl_vars['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['user']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
        
         <td><?php echo ((is_array($_tmp=$this->_tpl_vars['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
         <td><a href="<?php echo $this->_tpl_vars['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
         
     </tr>
   <?php endforeach; endif; unset($_from); ?>     
</table>

<div class="SearchStatus" />

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    TableSearch(document.getElementById(\'searchField\'), document.getElementById(\'userTable\'),
                '; ?>
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:4f646b42ef837d4ef57b94183fccefd8#10}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:4f646b42ef837d4ef57b94183fccefd8#10}'; endif;?>
"<?php echo '
                );   
    $($(".SortHeading").get(0)).click();
    
});



'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>