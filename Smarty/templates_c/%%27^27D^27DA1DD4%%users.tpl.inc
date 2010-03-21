<?php /* Smarty version 2.6.26, created on 2010-02-16 14:29:20
         compiled from users.tpl */

$this->_cache_serials['./Smarty/templates_c/%%27^27D^27DA1DD4%%users.tpl.inc'] = '4f646b42ef837d4ef57b94183fccefd8';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'users.tpl', 22, false),array('function', 'url', 'users.tpl', 25, false),array('function', 'initializeGetFormFields', 'users.tpl', 26, false),array('function', 'sortheading', 'users.tpl', 38, false),array('modifier', 'escape', 'users.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_0(&$_smarty)
{
echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_1(&$_smarty)
{
echo url_smarty(array('page' => 'users'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_2(&$_smarty)
{
echo initializeGetFormFields_Smarty(array('search' => false), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_3(&$_smarty)
{
echo translate_smarty(array('id' => 'users_searchhint'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_4(&$_smarty)
{
echo translate_smarty(array('id' => 'users_search'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_5(&$_smarty)
{
echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_6(&$_smarty)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_7(&$_smarty)
{
echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_8(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => $_smarty->_tpl_vars['user']->id), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_9(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => $_smarty->_tpl_vars['user']->username), $_smarty);
}


function _smarty_tplfunc_4f646b42ef837d4ef57b94183fccefd8_10(&$_smarty)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $_smarty);
}



?>
