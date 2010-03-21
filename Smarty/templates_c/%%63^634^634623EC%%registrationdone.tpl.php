<?php /* Smarty version 2.6.26, created on 2010-02-15 16:07:00
         compiled from registrationdone.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'registrationdone.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%63^634^634623EC%%registrationdone.tpl.inc'] = 'e857db1224490bc5e8cfe69cff43d46b'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e857db1224490bc5e8cfe69cff43d46b#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'registration_done_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e857db1224490bc5e8cfe69cff43d46b#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['cookiewarning']): ?>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e857db1224490bc5e8cfe69cff43d46b#1}'; endif;echo translate_smarty(array('id' => 'cookiewarning'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e857db1224490bc5e8cfe69cff43d46b#1}'; endif;?>
</p>
<?php endif; ?>
<div>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e857db1224490bc5e8cfe69cff43d46b#2}'; endif;echo translate_smarty(array('id' => 'registration_done_main_text','username' => $this->_tpl_vars['user']->username), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e857db1224490bc5e8cfe69cff43d46b#2}'; endif;?>

</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 