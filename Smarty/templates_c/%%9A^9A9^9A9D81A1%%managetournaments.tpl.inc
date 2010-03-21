<?php /* Smarty version 2.6.26, created on 2010-02-17 09:35:25
         compiled from managetournaments.tpl */

$this->_cache_serials['./Smarty/templates_c/%%9A^9A9^9A9D81A1%%managetournaments.tpl.inc'] = '5264e412fc4bd4e34df54736696626cc';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managetournaments.tpl', 22, false),array('function', 'url', 'managetournaments.tpl', 25, false),array('modifier', 'escape', 'managetournaments.tpl', 38, false),array('modifier', 'date_format', 'managetournaments.tpl', 55, false),)), $this); ?>
<?php
function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_0(&$this)
{
echo translate_smarty(array('assign' => 'title','id' => 'managetournaments_title'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_1(&$this)
{
echo url_smarty(array('page' => 'edittournament','id' => 'new'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_2(&$this)
{
echo translate_smarty(array('id' => 'new_tournament'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_3(&$this)
{
echo translate_smarty(array('id' => 'name'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_4(&$this)
{
echo translate_smarty(array('id' => 'year'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_5(&$this)
{
echo translate_smarty(array('id' => 'scorecalculation'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_6(&$this)
{
echo translate_smarty(array('id' => 'available'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_7(&$this)
{
echo translate_smarty(array('id' => 'edit'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_8(&$this)
{
echo translate_smarty(array('id' => "yes!"), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_9(&$this)
{
echo translate_smarty(array('id' => 'not'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_10(&$this)
{
echo url_smarty(array('page' => 'edittournament','id' => $this->_tpl_vars['tournament']->id), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_11(&$this)
{
echo translate_smarty(array('id' => 'edit'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_12(&$this)
{
echo url_smarty(array('page' => 'edittournament','id' => 'new'), $this);
}


function _smarty_tplfunc_5264e412fc4bd4e34df54736696626cc_13(&$this)
{
echo translate_smarty(array('id' => 'new_tournament'), $this);
}



?>
