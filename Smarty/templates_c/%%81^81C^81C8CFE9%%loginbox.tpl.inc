<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:07
         compiled from include/loginbox.tpl */

$this->_cache_serials['./Smarty/templates_c/%%81^81C^81C8CFE9%%loginbox.tpl.inc'] = '2927a3ca7af64d7402c599f4a163df2a';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'include/loginbox.tpl', 24, false),array('function', 'translate', 'include/loginbox.tpl', 24, false),array('modifier', 'escape', 'include/loginbox.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_0(&$this)
{
echo url_smarty(array('page' => 'login'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_1(&$this)
{
echo translate_smarty(array('id' => 'login'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_2(&$this)
{
echo url_smarty(array('page' => 'register'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_3(&$this)
{
echo translate_smarty(array('id' => 'register'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_4(&$this)
{
echo translate_smarty(array('id' => 'close'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_5(&$this)
{
echo translate_smarty(array('id' => 'username'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_6(&$this)
{
echo translate_smarty(array('id' => 'password'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_7(&$this)
{
echo translate_smarty(array('id' => 'loginbutton'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_8(&$this)
{
echo url_smarty(array('page' => 'register'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_9(&$this)
{
echo translate_smarty(array('id' => 'register'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_10(&$this)
{
echo url_smarty(array('page' => 'recoverpassword'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_11(&$this)
{
echo translate_smarty(array('id' => 'forgottenpassword'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_12(&$this)
{
echo translate_smarty(array('id' => 'loginform_loggedin_title'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_13(&$this)
{
echo translate_smarty(array('id' => 'loginform_loggedin_as','user' => $this->_tpl_vars['user']->username,'firstname' => $this->_tpl_vars['user']->firstname,'lastname' => $this->_tpl_vars['user']->lastname), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_14(&$this)
{
echo url_smarty(array('page' => 'myinfo'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_15(&$this)
{
echo translate_smarty(array('id' => 'my_info'), $this);
}


function _smarty_tplfunc_2927a3ca7af64d7402c599f4a163df2a_16(&$this)
{
echo translate_smarty(array('id' => 'logout'), $this);
}



?>
