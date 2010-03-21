<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:26
         compiled from admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'admin.tpl', 22, false),array('function', 'submenulinks', 'admin.tpl', 27, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%62^620^6206D997%%admin.tpl.inc'] = 'aa5b8fc4f074b6edde8015c798521c9b'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:aa5b8fc4f074b6edde8015c798521c9b#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'admin_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:aa5b8fc4f074b6edde8015c798521c9b#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:aa5b8fc4f074b6edde8015c798521c9b#1}'; endif;echo translate_smarty(array('id' => 'admin_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:aa5b8fc4f074b6edde8015c798521c9b#1}'; endif;?>


<?php echo submenulinks_smarty(array(), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>