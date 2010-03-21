<?php /* Smarty version 2.6.26, created on 2010-02-16 14:52:14
         compiled from eventads.tpl */

$this->_cache_serials['./Smarty/templates_c/%%2E^2E3^2E3E93A9%%eventads.tpl.inc'] = 'f2a3c975ef2c5e8af1b690c61d5c8e51';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventads.tpl', 27, false),array('function', 'url', 'eventads.tpl', 37, false),)), $this); ?>
<?php
function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_0(&$_smarty)
{
echo translate_smarty(array('id' => 'ad_location'), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_1(&$_smarty)
{
echo translate_smarty(array('id' => 'ad_type'), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_2(&$_smarty)
{
echo translate_smarty(array('id' => 'ad_actions'), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_3(&$_smarty)
{
echo translate_smarty(array('id' => $_smarty->_tpl_vars['locid']), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_4(&$_smarty)
{
echo translate_smarty(array('id' => $_smarty->_tpl_vars['typeid']), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_5(&$_smarty)
{
echo url_smarty(array('page' => 'editad','id' => $_smarty->_tpl_vars['event']->id,'adType' => $_smarty->_tpl_vars['ad']->contentId), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_6(&$_smarty)
{
echo translate_smarty(array('id' => 'edit'), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_7(&$_smarty)
{
echo url_smarty(array('page' => 'editad','id' => $_smarty->_tpl_vars['event']->id,'adType' => $_smarty->_tpl_vars['ad']->contentId,'preview' => 1), $_smarty);
}


function _smarty_tplfunc_f2a3c975ef2c5e8af1b690c61d5c8e51_8(&$_smarty)
{
echo translate_smarty(array('id' => 'preview'), $_smarty);
}



?>
