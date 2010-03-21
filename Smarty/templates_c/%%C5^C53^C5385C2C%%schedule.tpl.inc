<?php /* Smarty version 2.6.26, created on 2010-02-16 14:45:53
         compiled from eventviews/schedule.tpl */

$this->_cache_serials['./Smarty/templates_c/%%C5^C53^C5385C2C%%schedule.tpl.inc'] = 'b7a7064c589015121323320b1afb117b';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'eventviews/schedule.tpl', 37, false),array('function', 'translate', 'eventviews/schedule.tpl', 38, false),array('function', 'url', 'eventviews/schedule.tpl', 68, false),array('modifier', 'date_format', 'eventviews/schedule.tpl', 39, false),array('modifier', 'escape', 'eventviews/schedule.tpl', 60, false),)), $this); ?>
<?php
function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_0(&$this)
{
echo translate_smarty(array('id' => 'round_title','number' => $this->_tpl_vars['num']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_1(&$this)
{
echo translate_smarty(array('id' => 'sequential_start','time' => $this->_tpl_vars['start']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_2(&$this)
{
echo translate_smarty(array('id' => 'simultaneous_start','time' => $this->_tpl_vars['start']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_3(&$this)
{
echo translate_smarty(array('id' => 'your_group'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_4(&$this)
{
echo translate_smarty(array('id' => 'preliminary'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_5(&$this)
{
echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['0']['StartingHole']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_6(&$this)
{
echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_7(&$this)
{
echo translate_smarty(array('id' => 'print_score_card'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_8(&$this)
{
echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'schedule','round' => $this->_tpl_vars['num']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_9(&$this)
{
echo translate_smarty(array('id' => 'view_group_list'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_10(&$this)
{
echo translate_smarty(array('id' => 'groups_not_finished'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_11(&$this)
{
echo translate_smarty(array('id' => 'round_title','number' => $_GET['round']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_12(&$this)
{
echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_13(&$this)
{
echo translate_smarty(array('id' => 'print_score_card'), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_14(&$this)
{
echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['StartingHole']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_15(&$this)
{
echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);
}


function _smarty_tplfunc_b7a7064c589015121323320b1afb117b_16(&$this)
{
echo translate_smarty(array('id' => 'print_score_card'), $this);
}



?>
