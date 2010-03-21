<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:14
         compiled from eventviews/leaderboard.tpl */

$this->_cache_serials['./Smarty/templates_c/%%86^86F^86F64DE5%%leaderboard.tpl.inc'] = '5c17b4d39f72ab32c6b57151c86e15b2';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/leaderboard.tpl', 77, false),array('function', 'math', 'eventviews/leaderboard.tpl', 85, false),array('function', 'counter', 'eventviews/leaderboard.tpl', 92, false),array('modifier', 'escape', 'eventviews/leaderboard.tpl', 88, false),)), $this); ?>
<?php
function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_0(&$this)
{
echo translate_smarty(array('id' => 'preliminary_results'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_1(&$this)
{
echo translate_smarty(array('id' => 'result_pos'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_2(&$this)
{
echo translate_smarty(array('id' => 'result_name'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_3(&$this)
{
echo translate_smarty(array('id' => 'round_number_short','number' => $this->_tpl_vars['roundNumber']), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_4(&$this)
{
echo translate_smarty(array('id' => 'leaderboard_hole'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_5(&$this)
{
echo translate_smarty(array('id' => 'result_cumulative'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_6(&$this)
{
echo translate_smarty(array('id' => 'result_tournament'), $this);
}


function _smarty_tplfunc_5c17b4d39f72ab32c6b57151c86e15b2_7(&$this)
{
echo translate_smarty(array('id' => 'result_sd_panel'), $this);
}



?>
