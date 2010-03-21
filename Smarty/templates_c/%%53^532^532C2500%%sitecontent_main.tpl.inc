<?php /* Smarty version 2.6.26, created on 2010-02-16 13:09:25
         compiled from sitecontent_main.tpl */

$this->_cache_serials['./Smarty/templates_c/%%53^532^532C2500%%sitecontent_main.tpl.inc'] = '46fbb514cff5cd22dc907ee83f3a0b28';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'sitecontent_main.tpl', 22, false),array('function', 'url', 'sitecontent_main.tpl', 30, false),array('modifier', 'escape', 'sitecontent_main.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'sitecontent_title'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_1(&$_smarty)
{
echo translate_smarty(array('id' => 'admin_sitecontent_main_text'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_2(&$_smarty)
{
echo url_smarty(array('page' => 'sitecontent','id' => $_smarty->_tpl_vars['link']['type']), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_3(&$_smarty)
{
echo translate_smarty(array('id' => 'edit'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_4(&$_smarty)
{
echo url_smarty(array('page' => 'content','id' => $_smarty->_tpl_vars['link']['type']), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_5(&$_smarty)
{
echo translate_smarty(array('id' => 'preview'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_6(&$_smarty)
{
echo translate_smarty(array('id' => 'sitecontent_custom_text'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_7(&$_smarty)
{
echo url_smarty(array('page' => 'sitecontent','id' => $_smarty->_tpl_vars['link']['id'],'mode' => 'custom'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_8(&$_smarty)
{
echo translate_smarty(array('id' => 'edit'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_9(&$_smarty)
{
echo url_smarty(array('page' => 'content','id' => $_smarty->_tpl_vars['link']['title']), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_10(&$_smarty)
{
echo translate_smarty(array('id' => 'preview'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_11(&$_smarty)
{
echo url_smarty(array('page' => 'sitecontent','id' => "*",'mode' => 'custom'), $_smarty);
}


function _smarty_tplfunc_46fbb514cff5cd22dc907ee83f3a0b28_12(&$_smarty)
{
echo translate_smarty(array('id' => 'new_page'), $_smarty);
}



?>
