<?php /* Smarty version 2.6.26, created on 2010-02-13 17:03:27
         compiled from manageevent_official.tpl */

$this->_cache_serials['./Smarty/templates_c/%%AB^AB2^AB22DAAC%%manageevent_official.tpl.inc'] = '88c2ff80068a9552662067616953d52a';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageevent_official.tpl', 25, false),array('function', 'submenulinks', 'manageevent_official.tpl', 26, false),array('function', 'math', 'manageevent_official.tpl', 31, false),array('function', 'url', 'manageevent_official.tpl', 32, false),)), $this); ?>
<?php
function _smarty_tplfunc_88c2ff80068a9552662067616953d52a_0(&$this)
{
echo translate_smarty(array('id' => 'manage_event_text'), $this);
}


function _smarty_tplfunc_88c2ff80068a9552662067616953d52a_1(&$this)
{
echo translate_smarty(array('id' => 'print_score_cards_help'), $this);
}


function _smarty_tplfunc_88c2ff80068a9552662067616953d52a_2(&$this)
{
echo url_smarty(array('page' => 'printscorecard','round' => $this->_tpl_vars['roundnum'],'id' => $_GET['id']), $this);
}


function _smarty_tplfunc_88c2ff80068a9552662067616953d52a_3(&$this)
{
echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['roundnum']), $this);
}


function _smarty_tplfunc_88c2ff80068a9552662067616953d52a_4(&$this)
{
echo translate_smarty(array('id' => 'preliminary'), $this);
}



?>
