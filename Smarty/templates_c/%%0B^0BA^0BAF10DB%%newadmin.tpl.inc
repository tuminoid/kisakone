<?php /* Smarty version 2.6.26, created on 2010-02-16 12:45:41
         compiled from newadmin.tpl */

$this->_cache_serials['./Smarty/templates_c/%%0B^0BA^0BAF10DB%%newadmin.tpl.inc'] = 'b48b1b3f0252e7403efbd280a637c9f3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'newadmin.tpl', 22, false),array('function', 'formerror', 'newadmin.tpl', 40, false),array('modifier', 'escape', 'newadmin.tpl', 39, false),)), $this); ?>
<?php
function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_0(&$_smarty)
{
echo translate_smarty(array('id' => 'newadmin_title','assign' => 'title'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_1(&$_smarty)
{
echo translate_smarty(array('id' => 'admin_created','username' => $_POST['username']), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_2(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_contact_info'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_3(&$_smarty)
{
echo translate_smarty(array('id' => 'last_name'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_4(&$_smarty)
{
echo formerror_smarty(array('field' => 'lastname'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_5(&$_smarty)
{
echo translate_smarty(array('id' => 'first_name'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_6(&$_smarty)
{
echo formerror_smarty(array('field' => 'firstname'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_7(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_email'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_8(&$_smarty)
{
echo formerror_smarty(array('field' => 'email'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_9(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_user_info'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_10(&$_smarty)
{
echo translate_smarty(array('id' => 'username'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_11(&$_smarty)
{
echo formerror_smarty(array('field' => 'username'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_12(&$_smarty)
{
echo translate_smarty(array('id' => 'password'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_13(&$_smarty)
{
echo formerror_smarty(array('field' => 'password'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_14(&$_smarty)
{
echo translate_smarty(array('id' => 'password_repeat'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_15(&$_smarty)
{
echo formerror_smarty(array('field' => 'password2'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_16(&$_smarty)
{
echo translate_smarty(array('id' => 'user_access_level'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_17(&$_smarty)
{
echo translate_smarty(array('id' => 'access_level_admin'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_18(&$_smarty)
{
echo translate_smarty(array('id' => 'access_level_manager'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_19(&$_smarty)
{
echo formerror_smarty(array('field' => 'access'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_20(&$_smarty)
{
echo translate_smarty(array('id' => 'reg_finalize'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_21(&$_smarty)
{
echo translate_smarty(array('id' => 'form_accept'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_22(&$_smarty)
{
echo translate_smarty(array('id' => 'form_cancel'), $_smarty);
}


function _smarty_tplfunc_b48b1b3f0252e7403efbd280a637c9f3_23(&$_smarty)
{
echo translate_smarty(array('id' => 'FormError_Terms','escape' => false), $_smarty);
}



?>
