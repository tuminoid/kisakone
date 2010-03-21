<?php /* Smarty version 2.6.26, created on 2010-02-13 18:28:55
         compiled from manage_users.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manage_users.tpl', 25, false),array('function', 'submenulinks', 'manage_users.tpl', 27, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%47^47D^47D3A8B0%%manage_users.tpl.inc'] = 'a971dd33098a87f5c7f83c9b81b12a9a'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a971dd33098a87f5c7f83c9b81b12a9a#0}'; endif;echo translate_smarty(array('id' => 'admin_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a971dd33098a87f5c7f83c9b81b12a9a#0}'; endif;?>


<?php echo submenulinks_smarty(array(), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>