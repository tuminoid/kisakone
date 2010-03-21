<?php /* Smarty version 2.6.26, created on 2010-03-06 10:37:47
         compiled from changepassword.tpl */

$this->_cache_serials['./Smarty/templates_c/%%D5^D55^D556538A%%changepassword.tpl.inc'] = 'ae6d5b9013c1c55df82a50de9e6e741c';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'changepassword.tpl', 22, false),array('function', 'formerror', 'changepassword.tpl', 48, false),)), $this); ?>
<?php
function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_0(&$_smarty)
{
echo translate_smarty(array('id' => 'changepassword_title','assign' => 'title'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_1(&$_smarty)
{
echo translate_smarty(array('id' => 'recover_password_help_final'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_2(&$_smarty)
{
echo translate_smarty(array('id' => 'change_password_help'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_3(&$_smarty)
{
echo translate_smarty(array('id' => 'recovering_password_for','username' => $_smarty->_tpl_vars['username']), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_4(&$_smarty)
{
echo translate_smarty(array('id' => 'old_password'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_5(&$_smarty)
{
echo translate_smarty(array('id' => 'admin_changing_password'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_6(&$_smarty)
{
echo formerror_smarty(array('field' => 'current_password'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_7(&$_smarty)
{
echo translate_smarty(array('id' => 'new_password'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_8(&$_smarty)
{
echo formerror_smarty(array('field' => 'password'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_9(&$_smarty)
{
echo translate_smarty(array('id' => 'password_repeat'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_10(&$_smarty)
{
echo formerror_smarty(array('field' => 'password2'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_11(&$_smarty)
{
echo translate_smarty(array('id' => 'form_accept'), $_smarty);
}


function _smarty_tplfunc_ae6d5b9013c1c55df82a50de9e6e741c_12(&$_smarty)
{
echo translate_smarty(array('id' => 'form_cancel'), $_smarty);
}



?>
