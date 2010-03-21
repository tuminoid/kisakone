<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:06
         compiled from index.tpl */

$this->_cache_serials['./Smarty/templates_c/%%45^45E^45E480CD%%index.tpl.inc'] = 'f4ee3f63ffa29c740fd6732af3baa213';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'index.tpl', 57, false),array('function', 'url', 'index.tpl', 80, false),array('modifier', 'escape', 'index.tpl', 80, false),)), $this); ?>
<?php
function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_0(&$this)
{
echo translate_smarty(array('id' => 'relevant_events'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_1(&$this)
{
echo translate_smarty(array('id' => 'upcoming_events'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_2(&$this)
{
echo translate_smarty(array('id' => 'past_events'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_3(&$this)
{
echo translate_smarty(array('id' => 'event_name'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_4(&$this)
{
echo translate_smarty(array('id' => 'event_location'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_5(&$this)
{
echo translate_smarty(array('id' => 'event_level'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_6(&$this)
{
echo translate_smarty(array('id' => 'event_date'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_7(&$this)
{
echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_8(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_9(&$this)
{
echo translate_smarty(array('id' => 'event_results'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_10(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_11(&$this)
{
echo translate_smarty(array('id' => 'results_available'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_12(&$this)
{
echo translate_smarty(array('id' => 'your_standing','standing' => $this->_tpl_vars['event']->standing), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_13(&$this)
{
echo translate_smarty(array('id' => 'fee_paid'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_14(&$this)
{
echo translate_smarty(array('id' => 'fee_not_paid'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_15(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'payment','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_16(&$this)
{
echo translate_smarty(array('id' => 'fee_payment_info'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_17(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_18(&$this)
{
echo translate_smarty(array('id' => 'event_cancel_signup'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_19(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_20(&$this)
{
echo translate_smarty(array('id' => 'event_signup'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_21(&$this)
{
echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_22(&$this)
{
echo translate_smarty(array('id' => 'sign_up_here'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_23(&$this)
{
echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_24(&$this)
{
echo translate_smarty(array('id' => 'event_manage'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_25(&$this)
{
echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_26(&$this)
{
echo translate_smarty(array('id' => 'event_enter_results'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_27(&$this)
{
echo url_smarty(array('page' => 'editnews','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_28(&$this)
{
echo translate_smarty(array('id' => 'event_add_news'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_29(&$this)
{
echo translate_smarty(array('id' => 'no_matching_events'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_30(&$this)
{
echo url_smarty(array('page' => 'events','id' => 'upcoming'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_31(&$this)
{
echo translate_smarty(array('id' => 'show_all'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_32(&$this)
{
echo url_smarty(array('page' => 'eventarchive'), $this);
}


function _smarty_tplfunc_f4ee3f63ffa29c740fd6732af3baa213_33(&$this)
{
echo translate_smarty(array('id' => 'show_archive'), $this);
}



?>
