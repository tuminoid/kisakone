<?php /* Smarty version 2.6.26, created on 2010-02-16 12:51:39
         compiled from eventarchive.tpl */

$this->_cache_serials['./Smarty/templates_c/%%BF^BF8^BF8DD15A%%eventarchive.tpl.inc'] = 'd41cfa1a79f1fb427c5e64537f543f1c';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventarchive.tpl', 22, false),array('function', 'url', 'eventarchive.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_d41cfa1a79f1fb427c5e64537f543f1c_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'eventarchive_title'), $_smarty);
}


function _smarty_tplfunc_d41cfa1a79f1fb427c5e64537f543f1c_1(&$_smarty)
{
echo translate_smarty(array('id' => 'eventarchive_main_text'), $_smarty);
}


function _smarty_tplfunc_d41cfa1a79f1fb427c5e64537f543f1c_2(&$_smarty)
{
echo url_smarty(array('page' => 'events','id' => $_smarty->_tpl_vars['year']), $_smarty);
}



?>
