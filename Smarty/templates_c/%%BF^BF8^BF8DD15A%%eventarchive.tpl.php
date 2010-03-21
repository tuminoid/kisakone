<?php /* Smarty version 2.6.26, created on 2010-02-16 12:51:39
         compiled from eventarchive.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventarchive.tpl', 22, false),array('function', 'url', 'eventarchive.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%BF^BF8^BF8DD15A%%eventarchive.tpl.inc'] = 'd41cfa1a79f1fb427c5e64537f543f1c'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d41cfa1a79f1fb427c5e64537f543f1c#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'eventarchive_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d41cfa1a79f1fb427c5e64537f543f1c#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d41cfa1a79f1fb427c5e64537f543f1c#1}'; endif;echo translate_smarty(array('id' => 'eventarchive_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d41cfa1a79f1fb427c5e64537f543f1c#1}'; endif;?>


<ul>
    <?php $_from = $this->_tpl_vars['years']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year']):
?>
        <li><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d41cfa1a79f1fb427c5e64537f543f1c#2}'; endif;echo url_smarty(array('page' => 'events','id' => $this->_tpl_vars['year']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d41cfa1a79f1fb427c5e64537f543f1c#2}'; endif;?>
"><?php echo $this->_tpl_vars['year']; ?>
</a></li>
    <?php endforeach; endif; unset($_from); ?>
</ul>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>