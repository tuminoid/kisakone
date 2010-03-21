<?php /* Smarty version 2.6.26, created on 2010-02-13 13:59:49
         compiled from managefees.tpl */

$this->_cache_serials['./Smarty/templates_c/%%1D^1D6^1D602AEE%%managefees.tpl.inc'] = '96f2ab93f2f223ee8b92311953537827';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managefees.tpl', 22, false),array('function', 'url', 'managefees.tpl', 25, false),array('function', 'initializeGetFormFields', 'managefees.tpl', 26, false),array('function', 'sortheading', 'managefees.tpl', 40, false),array('modifier', 'escape', 'managefees.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_0(&$this)
{
echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_1(&$this)
{
echo url_smarty(array('page' => 'managefees'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_2(&$this)
{
echo initializeGetFormFields_Smarty(array('search' => false), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_3(&$this)
{
echo translate_smarty(array('id' => 'users_searchhint'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_4(&$this)
{
echo translate_smarty(array('id' => 'users_search'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_5(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_6(&$this)
{
echo sortheading_smarty(array('field' => 'name','id' => 'users_name','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_7(&$this)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_8(&$this)
{
echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_9(&$this)
{
echo sortheading_smarty(array('field' => 1,'id' => 'user_licensefee','sortType' => 'checkboxchecked'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_10(&$this)
{
echo sortheading_smarty(array('field' => 1,'id' => 'user_membershipfee','sortType' => 'checkboxchecked'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_11(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_12(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_13(&$this)
{
echo translate_smarty(array('id' => 'fee'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_14(&$this)
{
echo translate_smarty(array('id' => 'fee'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_15(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_16(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_96f2ab93f2f223ee8b92311953537827_17(&$this)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $this);
}



?>
