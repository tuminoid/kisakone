<?php /* Smarty version 2.6.26, created on 2010-02-15 16:06:16
         compiled from manageevent.tpl */

$this->_cache_serials['./Smarty/templates_c/%%92^923^9235BBCE%%manageevent.tpl.inc'] = '2fc7e6ac57a37373cee8e2671d8a09a3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageevent.tpl', 26, false),array('function', 'submenulinks', 'manageevent.tpl', 31, false),array('function', 'math', 'manageevent.tpl', 36, false),array('function', 'url', 'manageevent.tpl', 37, false),)), $this); ?>
<?php
function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_0(&$this)
{
echo translate_smarty(array('id' => 'event_edit_notification'), $this);
}


function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_1(&$this)
{
echo translate_smarty(array('id' => 'manage_event_text'), $this);
}


function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_2(&$this)
{
echo translate_smarty(array('id' => 'print_score_cards_help'), $this);
}


function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_3(&$this)
{
echo url_smarty(array('page' => 'printscorecard','round' => $this->_tpl_vars['roundnum'],'id' => $_GET['id']), $this);
}


function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_4(&$this)
{
echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['roundnum']), $this);
}


function _smarty_tplfunc_2fc7e6ac57a37373cee8e2671d8a09a3_5(&$this)
{
echo translate_smarty(array('id' => 'preliminary'), $this);
}



?>
