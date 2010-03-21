<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:13
         compiled from eventviews/index.tpl */

$this->_cache_serials['./Smarty/templates_c/%%EB^EBB^EBB66FD6%%index.tpl.inc'] = 'e859e5cb2e30c170c3238909bdbf8f3d';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/index.tpl', 29, false),array('function', 'math', 'eventviews/index.tpl', 77, false),array('function', 'url', 'eventviews/index.tpl', 97, false),array('modifier', 'escape', 'eventviews/index.tpl', 30, false),array('modifier', 'date_format', 'eventviews/index.tpl', 79, false),)), $this); ?>
<?php
function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_0(&$this)
{
echo translate_smarty(array('id' => 'event_name'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_1(&$this)
{
echo translate_smarty(array('id' => 'event_venue'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_2(&$this)
{
echo translate_smarty(array('id' => 'event_date'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_3(&$this)
{
echo translate_smarty(array('id' => 'event_level'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_4(&$this)
{
echo translate_smarty(array('id' => 'event_tournament'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_5(&$this)
{
echo translate_smarty(array('id' => 'event_contact'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_6(&$this)
{
echo translate_smarty(array('id' => 'schedule'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_7(&$this)
{
echo translate_smarty(array('id' => 'round_number','number' => ''), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_8(&$this)
{
echo translate_smarty(array('id' => 'round_starttime'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_9(&$this)
{
echo translate_smarty(array('id' => 'your_group_is'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_10(&$this)
{
echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['number']), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_11(&$this)
{
echo translate_smarty(array('id' => 'your_group_starting','start' => $this->_tpl_vars['groupstart']), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_12(&$this)
{
echo translate_smarty(array('id' => 'preliminary'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_13(&$this)
{
echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['StartingHole']), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_14(&$this)
{
echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'schedule'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_15(&$this)
{
echo translate_smarty(array('id' => 'full_schedule'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_16(&$this)
{
echo translate_smarty(array('id' => 'relevant_news'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_17(&$this)
{
echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'newsarchive'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_18(&$this)
{
echo translate_smarty(array('id' => 'news_archive'), $this);
}


function _smarty_tplfunc_e859e5cb2e30c170c3238909bdbf8f3d_19(&$this)
{
echo translate_smarty(array('id' => 'no_news'), $this);
}



?>
