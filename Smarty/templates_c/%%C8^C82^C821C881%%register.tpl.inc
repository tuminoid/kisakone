<?php /* Smarty version 2.6.26, created on 2010-02-16 14:17:11
         compiled from register.tpl */

$this->_cache_serials['./Smarty/templates_c/%%C8^C82^C821C881%%register.tpl.inc'] = '9716f6edcd79a43b420fae55bc5e58ae';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'register.tpl', 22, false),array('function', 'formerror', 'register.tpl', 34, false),array('function', 'html_select_date', 'register.tpl', 85, false),array('function', 'url', 'register.tpl', 95, false),array('modifier', 'escape', 'register.tpl', 33, false),)), $this); ?>
<?php
function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_0(&$_smarty)
{
echo translate_smarty(array('id' => 'register_title','assign' => 'title'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_1(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_contact_info'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_2(&$_smarty)
{
echo translate_smarty(array('id' => 'last_name'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_3(&$_smarty)
{
echo formerror_smarty(array('field' => 'lastname'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_4(&$_smarty)
{
echo translate_smarty(array('id' => 'first_name'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_5(&$_smarty)
{
echo formerror_smarty(array('field' => 'firstname'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_6(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_email'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_7(&$_smarty)
{
echo formerror_smarty(array('field' => 'email'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_8(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_user_info'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_9(&$_smarty)
{
echo translate_smarty(array('id' => 'username'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_10(&$_smarty)
{
echo formerror_smarty(array('field' => 'username'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_11(&$_smarty)
{
echo translate_smarty(array('id' => 'password'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_12(&$_smarty)
{
echo formerror_smarty(array('field' => 'password'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_13(&$_smarty)
{
echo translate_smarty(array('id' => 'password_repeat'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_14(&$_smarty)
{
echo formerror_smarty(array('field' => 'password2'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_15(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_player_info'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_16(&$_smarty)
{
echo translate_smarty(array('id' => 'pdga_number'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_17(&$_smarty)
{
echo formerror_smarty(array('field' => 'pdga'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_18(&$_smarty)
{
echo translate_smarty(array('id' => 'gender'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_19(&$_smarty)
{
echo translate_smarty(array('id' => 'male'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_20(&$_smarty)
{
echo translate_smarty(array('id' => 'female'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_21(&$_smarty)
{
echo formerror_smarty(array('field' => 'gender'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_22(&$_smarty)
{
echo translate_smarty(array('id' => 'dob'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_23(&$_smarty)
{
echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_24(&$_smarty)
{
echo formerror_smarty(array('field' => 'dob'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_25(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_termsandconditions'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_26(&$_smarty)
{
echo url_smarty(array('page' => 'termsandconditions'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_27(&$_smarty)
{
echo translate_smarty(array('id' => 'termsandconditionslinktitle'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_28(&$_smarty)
{
echo translate_smarty(array('id' => 'termsandconditions','link' => $_smarty->_tpl_vars['termslink']), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_29(&$_smarty)
{
echo formerror_smarty(array('field' => 'termsandconditions'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_30(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_finalize'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_31(&$_smarty)
{
echo translate_smarty(array('id' => 'form_accept'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_32(&$_smarty)
{
echo translate_smarty(array('id' => 'form_cancel'), $_smarty);
}


function _smarty_tplfunc_9716f6edcd79a43b420fae55bc5e58ae_33(&$_smarty)
{
echo translate_smarty(array('id' => 'FormError_Terms','escape' => false), $_smarty);
}



?>
