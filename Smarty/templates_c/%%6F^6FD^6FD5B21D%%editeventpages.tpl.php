<?php /* Smarty version 2.6.26, created on 2010-02-16 14:43:54
         compiled from editeventpages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editeventpages.tpl', 22, false),array('function', 'submenulinks', 'editeventpages.tpl', 27, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6F^6FD^6FD5B21D%%editeventpages.tpl.inc'] = '0fbb613bb6eb45c837d55384ff6b8233'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0fbb613bb6eb45c837d55384ff6b8233#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editeventpages_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0fbb613bb6eb45c837d55384ff6b8233#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0fbb613bb6eb45c837d55384ff6b8233#1}'; endif;echo translate_smarty(array('id' => 'eventpages_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0fbb613bb6eb45c837d55384ff6b8233#1}'; endif;?>


<?php echo submenulinks_smarty(array(), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>