<?php /* Smarty version 2.6.26, created on 2010-03-20 10:05:05
         compiled from manage_email.tpl */

$this->_cache_serials['./Smarty/templates_c/%%FD^FDC^FDCC1FC0%%manage_email.tpl.inc'] = 'c61d96ba092cd80d64b972fed58f38c7';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manage_email.tpl', 24, false),array('function', 'url', 'manage_email.tpl', 30, false),array('modifier', 'escape', 'manage_email.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_c61d96ba092cd80d64b972fed58f38c7_0(&$_smarty)
{
echo translate_smarty(array('id' => 'admin_manage_email_text'), $_smarty);
}


function _smarty_tplfunc_c61d96ba092cd80d64b972fed58f38c7_1(&$_smarty)
{
echo url_smarty(array('page' => 'editemail','id' => $_smarty->_tpl_vars['link']['type']), $_smarty);
}


function _smarty_tplfunc_c61d96ba092cd80d64b972fed58f38c7_2(&$_smarty)
{
echo translate_smarty(array('id' => 'edit'), $_smarty);
}


function _smarty_tplfunc_c61d96ba092cd80d64b972fed58f38c7_3(&$_smarty)
{
echo url_smarty(array('page' => 'editemail','id' => $_smarty->_tpl_vars['link']['type']), $_smarty);
}


function _smarty_tplfunc_c61d96ba092cd80d64b972fed58f38c7_4(&$_smarty)
{
echo translate_smarty(array('id' => 'preview'), $_smarty);
}



?>
