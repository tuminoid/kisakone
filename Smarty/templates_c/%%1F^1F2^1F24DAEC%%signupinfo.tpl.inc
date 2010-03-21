<?php /* Smarty version 2.6.26, created on 2010-02-15 16:09:28
         compiled from eventviews/signupinfo.tpl */

$this->_cache_serials['./Smarty/templates_c/%%1F^1F2^1F24DAEC%%signupinfo.tpl.inc'] = '6c509ed0d6b8802afb9d7b2474bc9146';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/signupinfo.tpl', 29, false),array('function', 'url', 'eventviews/signupinfo.tpl', 67, false),array('modifier', 'escape', 'eventviews/signupinfo.tpl', 55, false),)), $this); ?>
<?php
function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_0(&$this)
{
echo translate_smarty(array('id' => 'admin_cant_sign_up'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_1(&$this)
{
echo translate_smarty(array('id' => 'login_to_sign_up'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_2(&$this)
{
echo translate_smarty(array('id' => 'fees_necessary_for_signup_1'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_3(&$this)
{
echo translate_smarty(array('id' => 'fees_necessary_for_signup_2'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_4(&$this)
{
echo translate_smarty(array('id' => 'fees_necessary_for_signup_3'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_5(&$this)
{
echo translate_smarty(array('id' => 'not_signed_up'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_6(&$this)
{
echo translate_smarty(array('id' => 'signup'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_7(&$this)
{
echo translate_smarty(array('id' => 'cancel'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_8(&$this)
{
echo translate_smarty(array('id' => 'signed_up_and_paid'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_9(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $_GET['id']), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_10(&$this)
{
echo translate_smarty(array('id' => 'cancel_signup'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_11(&$this)
{
echo translate_smarty(array('id' => 'signed_up_not_paid'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_12(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'payment','id' => $_GET['id']), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_13(&$this)
{
echo translate_smarty(array('id' => 'event_payment'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_14(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $_GET['id']), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_15(&$this)
{
echo translate_smarty(array('id' => 'cancel_signup'), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_16(&$this)
{
echo translate_smarty(array('id' => 'signup_closed_dates','from' => $this->_tpl_vars['signupStart'],'to' => $this->_tpl_vars['signupEnd']), $this);
}


function _smarty_tplfunc_6c509ed0d6b8802afb9d7b2474bc9146_17(&$this)
{
echo translate_smarty(array('id' => 'signup_closed'), $this);
}



?>
