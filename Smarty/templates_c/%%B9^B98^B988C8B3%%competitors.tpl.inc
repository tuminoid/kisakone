<?php /* Smarty version 2.6.26, created on 2010-02-16 14:46:14
         compiled from eventviews/competitors.tpl */

$this->_cache_serials['./Smarty/templates_c/%%B9^B98^B988C8B3%%competitors.tpl.inc'] = '188cdf50c9dbc3d37465d06b3169981c';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'eventviews/competitors.tpl', 28, false),array('function', 'initializeGetFormFields', 'eventviews/competitors.tpl', 29, false),array('function', 'translate', 'eventviews/competitors.tpl', 31, false),array('function', 'sortheading', 'eventviews/competitors.tpl', 41, false),array('modifier', 'escape', 'eventviews/competitors.tpl', 32, false),)), $this); ?>
<?php
function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_0(&$_smarty)
{
echo url_smarty(array('page' => 'event','view' => 'competitors','id' => $_GET['id']), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_1(&$_smarty)
{
echo initializeGetFormFields_Smarty(array('search' => false), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_2(&$_smarty)
{
echo translate_smarty(array('id' => 'users_searchhint'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_3(&$_smarty)
{
echo translate_smarty(array('id' => 'users_search'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_4(&$_smarty)
{
echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_5(&$_smarty)
{
echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_6(&$_smarty)
{
echo sortheading_smarty(array('field' => 'ClassName','id' => 'class','sortType' => 'alphabetical'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_7(&$_smarty)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_8(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => $_smarty->_tpl_vars['participant']['user']->username), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_9(&$_smarty)
{
echo url_smarty(array('page' => 'user','id' => $_smarty->_tpl_vars['participant']['user']->username), $_smarty);
}


function _smarty_tplfunc_188cdf50c9dbc3d37465d06b3169981c_10(&$_smarty)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $_smarty);
}



?>
