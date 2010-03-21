<?php /* Smarty version 2.6.26, created on 2010-03-20 09:55:44
         compiled from eventfees.tpl */

$this->_cache_serials['./Smarty/templates_c/%%C5^C55^C5521537%%eventfees.tpl.inc'] = 'b41e78105872849554d041ee540a9b00';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventfees.tpl', 22, false),array('function', 'url', 'eventfees.tpl', 29, false),array('function', 'initializeGetFormFields', 'eventfees.tpl', 30, false),array('function', 'sortheading', 'eventfees.tpl', 48, false),array('modifier', 'escape', 'eventfees.tpl', 33, false),array('modifier', 'date_format', 'eventfees.tpl', 83, false),)), $this); ?>
<?php
function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_0(&$this)
{
echo translate_smarty(array('id' => 'eventfees_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_1(&$this)
{
echo translate_smarty(array('id' => 'toggle_menu'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_2(&$this)
{
echo url_smarty(array('page' => 'eventfees','id' => $_GET['id']), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_3(&$this)
{
echo initializeGetFormFields_Smarty(array('search' => false), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_4(&$this)
{
echo translate_smarty(array('id' => 'users_searchhint'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_5(&$this)
{
echo translate_smarty(array('id' => 'users_search'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_6(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_7(&$this)
{
echo translate_smarty(array('id' => 'remind_all'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_8(&$this)
{
echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_9(&$this)
{
echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_10(&$this)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_11(&$this)
{
echo sortheading_smarty(array('field' => 'Username','id' => 'users_id','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_12(&$this)
{
echo sortheading_smarty(array('field' => 1,'id' => 'users_eventfees','sortType' => 'checkboxchecked'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_13(&$this)
{
echo sortheading_smarty(array('field' => 1,'id' => 'eventfee_remind','sortType' => 'checkboxchecked'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_14(&$this)
{
echo sortheading_smarty(array('field' => 1,'id' => 'date','sortType' => 'date'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_15(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_16(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_17(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_18(&$this)
{
echo translate_smarty(array('id' => 'fee'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_19(&$this)
{
echo translate_smarty(array('id' => 'remind'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_20(&$this)
{
echo translate_smarty(array('id' => 'payment_date','date' => $this->_tpl_vars['date']), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_21(&$this)
{
echo translate_smarty(array('id' => 'signup_date','date' => $this->_tpl_vars['date']), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_22(&$this)
{
echo translate_smarty(array('id' => 'remind_all'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_23(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_24(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_b41e78105872849554d041ee540a9b00_25(&$this)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $this);
}



?>
