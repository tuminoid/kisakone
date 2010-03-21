<?php /* Smarty version 2.6.26, created on 2010-02-18 19:57:22
         compiled from addcompetitor.tpl */

$this->_cache_serials['./Smarty/templates_c/%%C6^C6E^C6E2469D%%addcompetitor.tpl.inc'] = '7b4f5c8a65e009087971d23a83b213c3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'addcompetitor.tpl', 22, false),array('function', 'initializeGetFormFields', 'addcompetitor.tpl', 33, false),array('function', 'url', 'addcompetitor.tpl', 40, false),array('function', 'formerror', 'addcompetitor.tpl', 104, false),array('function', 'html_select_date', 'addcompetitor.tpl', 148, false),array('function', 'html_options', 'addcompetitor.tpl', 164, false),array('modifier', 'escape', 'addcompetitor.tpl', 70, false),)), $this); ?>
<?php
function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_0(&$this)
{
echo translate_smarty(array('id' => 'addcompetitor_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_1(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_help'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_2(&$this)
{
echo initializeGetFormFields_Smarty(array('search' => false), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_3(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_prompt'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_4(&$this)
{
echo translate_smarty(array('id' => 'search'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_5(&$this)
{
echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => 'new'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_6(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_create_new'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_7(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_list_help'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_8(&$this)
{
echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => $this->_tpl_vars['user']->id), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_9(&$this)
{
echo translate_smarty(array('id' => 'select'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_10(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_no_username'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_11(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_nomatch'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_12(&$this)
{
echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => 'new'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_13(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_create_new'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_14(&$this)
{
echo translate_smarty(array('id' => 'reg_contact_info'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_15(&$this)
{
echo translate_smarty(array('id' => 'last_name'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_16(&$this)
{
echo formerror_smarty(array('field' => 'lastname'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_17(&$this)
{
echo translate_smarty(array('id' => 'first_name'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_18(&$this)
{
echo formerror_smarty(array('field' => 'firstname'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_19(&$this)
{
echo translate_smarty(array('id' => 'reg_email'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_20(&$this)
{
echo formerror_smarty(array('field' => 'email'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_21(&$this)
{
echo translate_smarty(array('id' => 'reg_user_info'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_22(&$this)
{
echo translate_smarty(array('id' => 'username'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_23(&$this)
{
echo formerror_smarty(array('field' => 'username'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_24(&$this)
{
echo translate_smarty(array('id' => 'reg_player_info'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_25(&$this)
{
echo translate_smarty(array('id' => 'pdga_number'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_26(&$this)
{
echo formerror_smarty(array('field' => 'pdga'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_27(&$this)
{
echo translate_smarty(array('id' => 'gender'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_28(&$this)
{
echo translate_smarty(array('id' => 'male'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_29(&$this)
{
echo translate_smarty(array('id' => 'female'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_30(&$this)
{
echo translate_smarty(array('id' => 'dob'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_31(&$this)
{
echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_32(&$this)
{
echo formerror_smarty(array('field' => 'dob'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_33(&$this)
{
echo translate_smarty(array('id' => 'add_competitor_class'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_34(&$this)
{
echo translate_smarty(array('id' => 'class'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_35(&$this)
{
echo formerror_smarty(array('field' => 'class'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_36(&$this)
{
echo translate_smarty(array('id' => 'reg_finalize'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_37(&$this)
{
echo translate_smarty(array('id' => 'form_accept'), $this);
}


function _smarty_tplfunc_7b4f5c8a65e009087971d23a83b213c3_38(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}



?>
