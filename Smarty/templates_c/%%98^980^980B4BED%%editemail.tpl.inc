<?php /* Smarty version 2.6.26, created on 2010-03-20 10:07:28
         compiled from editemail.tpl */

$this->_cache_serials['./Smarty/templates_c/%%98^980^980B4BED%%editemail.tpl.inc'] = '7918ad3a39b54fd611f9d7527a791430';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editemail.tpl', 24, false),array('modifier', 'escape', 'editemail.tpl', 35, false),array('modifier', 'nl2br', 'editemail.tpl', 47, false),)), $this); ?>
<?php
function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'editcontentpage_title'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_1(&$_smarty)
{
echo translate_smarty(array('id' => 'email_token_info'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_2(&$_smarty)
{
echo translate_smarty(array('id' => ((is_array($_tmp=$_smarty->_tpl_vars['description'])) ? $_smarty->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_3(&$_smarty)
{
echo translate_smarty(array('id' => 'title'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_4(&$_smarty)
{
echo translate_smarty(array('id' => 'content'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_5(&$_smarty)
{
echo translate_smarty(array('assign' => 'save_text','id' => 'form_save'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_6(&$_smarty)
{
echo translate_smarty(array('id' => 'form_preview'), $_smarty);
}


function _smarty_tplfunc_7918ad3a39b54fd611f9d7527a791430_7(&$_smarty)
{
echo translate_smarty(array('id' => 'form_cancel'), $_smarty);
}



?>
