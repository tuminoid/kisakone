<?php /* Smarty version 2.6.26, created on 2010-02-13 15:00:46
         compiled from tournament.tpl */

$this->_cache_serials['./Smarty/templates_c/%%41^418^41884409%%tournament.tpl.inc'] = '8fcfa1f6fe35d427f46cce27dcacd4f2';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'tournament.tpl', 22, false),array('function', 'math', 'tournament.tpl', 56, false),array('function', 'url', 'tournament.tpl', 58, false),array('modifier', 'escape', 'tournament.tpl', 25, false),array('modifier', 'date_format', 'tournament.tpl', 71, false),)), $this); ?>
<?php
function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_0(&$this)
{
echo translate_smarty(array('id' => 'tournament_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_1(&$this)
{
echo translate_smarty(array('id' => 'tournament_info'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_2(&$this)
{
echo translate_smarty(array('id' => 'tournament_name'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_3(&$this)
{
echo translate_smarty(array('id' => 'tournament_year'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_4(&$this)
{
echo translate_smarty(array('id' => 'tournament_participants'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_5(&$this)
{
echo translate_smarty(array('id' => 'tournament_events_held'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_6(&$this)
{
echo translate_smarty(array('id' => 'tournament_level'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_7(&$this)
{
echo translate_smarty(array('id' => 'tournament_scorecalculation'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_8(&$this)
{
echo translate_smarty(array('id' => 'tournament_events'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_9(&$this)
{
echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_10(&$this)
{
echo translate_smarty(array('id' => 'fee_not_paid'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_11(&$this)
{
echo url_smarty(array('page' => 'payfees','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_12(&$this)
{
echo translate_smarty(array('id' => 'fee_payment_info'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_13(&$this)
{
echo translate_smarty(array('id' => 'fee_paid'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_14(&$this)
{
echo url_smarty(array('page' => 'signup','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_15(&$this)
{
echo translate_smarty(array('id' => 'event_signup'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_16(&$this)
{
echo translate_smarty(array('id' => 'signup_by_start'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_17(&$this)
{
echo translate_smarty(array('id' => 'signup_by_end'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_18(&$this)
{
echo url_smarty(array('page' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_19(&$this)
{
echo translate_smarty(array('id' => 'event_cancel_signup'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_20(&$this)
{
echo url_smarty(array('page' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_21(&$this)
{
echo translate_smarty(array('id' => 'event_cancel_signup'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_22(&$this)
{
echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_23(&$this)
{
echo translate_smarty(array('id' => 'event_manage'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_24(&$this)
{
echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_25(&$this)
{
echo translate_smarty(array('id' => 'event_enter_results'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_26(&$this)
{
echo url_smarty(array('page' => 'addnews','id' => $this->_tpl_vars['event']->id), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_27(&$this)
{
echo translate_smarty(array('id' => 'event_add_news'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_28(&$this)
{
echo translate_smarty(array('id' => 'tournament_participants'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_29(&$this)
{
echo translate_smarty(array('id' => 'edit_tournament_tie_breakers_help'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_30(&$this)
{
echo translate_smarty(array('id' => 'tournament_pos'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_31(&$this)
{
echo translate_smarty(array('id' => 'tournament_part_name'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_32(&$this)
{
echo translate_smarty(array('id' => 'pdga'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_33(&$this)
{
echo translate_smarty(array('id' => 'tournament_event_positions'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_34(&$this)
{
echo translate_smarty(array('id' => 'tournament_overall'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_35(&$this)
{
echo translate_smarty(array('id' => 'tie_breaker'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_36(&$this)
{
echo translate_smarty(array('id' => 'tournament_event_score','event' => $this->_tpl_vars['num']), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_37(&$this)
{
echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['part']['Username']), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_38(&$this)
{
echo translate_smarty(array('id' => 'save'), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_39(&$this)
{
echo url_smarty(array('page' => 'tournament','id' => $_GET['id'],'edit' => 1), $this);
}


function _smarty_tplfunc_8fcfa1f6fe35d427f46cce27dcacd4f2_40(&$this)
{
echo translate_smarty(array('id' => 'edit_tournament_tie_breakers'), $this);
}



?>
