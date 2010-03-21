<?php /* Smarty version 2.6.26, created on 2010-02-14 11:37:57
         compiled from manageaccess.tpl */

$this->_cache_serials['./Smarty/templates_c/%%59^59D^59D4C34E%%manageaccess.tpl.inc'] = '29a431574925ff21e150df0423957ffc';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageaccess.tpl', 22, false),array('function', 'url', 'manageaccess.tpl', 25, false),array('function', 'initializeGetFormFields', 'manageaccess.tpl', 26, false),array('function', 'sortheading', 'manageaccess.tpl', 40, false),array('modifier', 'escape', 'manageaccess.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_0(&$_smarty)
{
echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_1(&$_smarty)
{
echo url_smarty(array('page' => 'manageaccess'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_2(&$_smarty)
{
echo initializeGetFormFields_Smarty(array('search' => false), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_3(&$_smarty)
{
echo translate_smarty(array('id' => 'users_searchhint'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_4(&$_smarty)
{
echo translate_smarty(array('id' => 'users_search'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_5(&$_smarty)
{
echo translate_smarty(array('id' => 'form_save'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_6(&$_smarty)
{
echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_7(&$_smarty)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_8(&$_smarty)
{
echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_9(&$_smarty)
{
echo sortheading_smarty(array('field' => 1,'id' => 'user_ban','sortType' => 'checkboxchecked'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_10(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => ($_smarty->_tpl_vars['userid'])), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_11(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => ($_smarty->_tpl_vars['userid'])), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_12(&$_smarty)
{
echo translate_smarty(array('id' => 'ban'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_13(&$_smarty)
{
echo translate_smarty(array('id' => 'form_save'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_14(&$_smarty)
{
echo translate_smarty(array('id' => 'form_cancel'), $_smarty);
}


function _smarty_tplfunc_29a431574925ff21e150df0423957ffc_15(&$_smarty)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $_smarty);
}



?>
