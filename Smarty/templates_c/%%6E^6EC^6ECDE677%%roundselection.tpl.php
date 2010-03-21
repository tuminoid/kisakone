<?php /* Smarty version 2.6.26, created on 2010-02-16 14:52:29
         compiled from support/roundselection.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/roundselection.tpl', 22, false),array('function', 'initializeGetFormFields', 'support/roundselection.tpl', 26, false),array('function', 'html_options', 'support/roundselection.tpl', 28, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6E^6EC^6ECDE677%%roundselection.tpl.inc'] = 'e5d31e02d67890be3fa84cf5c5f556e2'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5d31e02d67890be3fa84cf5c5f556e2#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'roundselection_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5d31e02d67890be3fa84cf5c5f556e2#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('ui' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="get">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5d31e02d67890be3fa84cf5c5f556e2#1}'; endif;echo initializeGetFormFields_Smarty(array('round' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5d31e02d67890be3fa84cf5c5f556e2#1}'; endif;?>

    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5d31e02d67890be3fa84cf5c5f556e2#2}'; endif;echo translate_smarty(array('id' => 'select_round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5d31e02d67890be3fa84cf5c5f556e2#2}'; endif;?>
</p>
    <p><select name="round"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['rounds']), $this);?>
</select></p>
    <p><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5d31e02d67890be3fa84cf5c5f556e2#3}'; endif;echo translate_smarty(array('id' => 'select'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5d31e02d67890be3fa84cf5c5f556e2#3}'; endif;?>
" /></p>
</form>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>