<?php /* Smarty version 2.6.26, created on 2010-02-16 14:50:08
         compiled from editnews.tpl */

$this->_cache_serials['./Smarty/templates_c/%%67^670^6700BF07%%editnews.tpl.inc'] = '0a5d201b8ebe1e53c148954720b94893';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editnews.tpl', 22, false),array('function', 'url', 'editnews.tpl', 26, false),array('modifier', 'escape', 'editnews.tpl', 31, false),array('modifier', 'date_format', 'editnews.tpl', 32, false),)), $this); ?>
<?php
function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'editnews_title'), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_1(&$_smarty)
{
echo translate_smarty(array('id' => 'editnews_title'), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_2(&$_smarty)
{
echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'content' => "*",'mode' => 'news'), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_3(&$_smarty)
{
echo translate_smarty(array('id' => 'new_news'), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_4(&$_smarty)
{
echo url_smarty(array('page' => 'editeventpage','mode' => 'news','id' => $_GET['id'],'content' => $_smarty->_tpl_vars['item']->id), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_5(&$_smarty)
{
echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'content' => "*",'mode' => 'news'), $_smarty);
}


function _smarty_tplfunc_0a5d201b8ebe1e53c148954720b94893_6(&$_smarty)
{
echo translate_smarty(array('id' => 'new_news'), $_smarty);
}



?>
