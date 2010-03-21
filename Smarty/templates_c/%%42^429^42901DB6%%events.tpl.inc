<?php /* Smarty version 2.6.26, created on 2010-02-15 16:04:11
         compiled from events.tpl */

$this->_cache_serials['./Smarty/templates_c/%%42^429^42901DB6%%events.tpl.inc'] = 'ecbf2dda6234a6618c437dc105b12ab5';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sortheading', 'events.tpl', 32, false),array('function', 'url', 'events.tpl', 42, false),array('function', 'translate', 'events.tpl', 52, false),array('modifier', 'escape', 'events.tpl', 42, false),)), $this); ?>
<?php
function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_0(&$this)
{
echo sortheading_smarty(array('field' => 'Name','id' => 'event_name','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_1(&$this)
{
echo sortheading_smarty(array('field' => 'VenueName','id' => 'event_location','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_2(&$this)
{
echo sortheading_smarty(array('field' => 'LevelName','id' => 'event_level','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_3(&$this)
{
echo sortheading_smarty(array('field' => 'Date','id' => 'event_date','sortType' => 'date'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_4(&$this)
{
echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_5(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_6(&$this)
{
echo translate_smarty(array('id' => 'event_results'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_7(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_8(&$this)
{
echo translate_smarty(array('id' => 'results_available'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_9(&$this)
{
echo translate_smarty(array('id' => 'your_standing','standing' => $this->_tpl_vars['event']->standing), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_10(&$this)
{
echo translate_smarty(array('id' => 'fee_paid'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_11(&$this)
{
echo translate_smarty(array('id' => 'fee_not_paid'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_12(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'payment','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_13(&$this)
{
echo translate_smarty(array('id' => 'fee_payment_info'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_14(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_15(&$this)
{
echo translate_smarty(array('id' => 'event_cancel_signup'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_16(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_17(&$this)
{
echo translate_smarty(array('id' => 'event_signup'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_18(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_19(&$this)
{
echo translate_smarty(array('id' => 'sign_up_here'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_20(&$this)
{
echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_21(&$this)
{
echo translate_smarty(array('id' => 'event_manage'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_22(&$this)
{
echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_23(&$this)
{
echo translate_smarty(array('id' => 'event_enter_results'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_24(&$this)
{
echo url_smarty(array('page' => 'editnews','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_25(&$this)
{
echo translate_smarty(array('id' => 'event_add_news'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_26(&$this)
{
echo translate_smarty(array('id' => 'no_matching_events'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_27(&$this)
{
echo url_smarty(array('page' => 'events','id' => 'currentYear'), $this);
}


function _smarty_tplfunc_ecbf2dda6234a6618c437dc105b12ab5_28(&$this)
{
echo translate_smarty(array('id' => 'all_current_year_events'), $this);
}



?>
