<?php /* Smarty version 2.6.26, created on 2010-02-16 14:54:15
         compiled from editrounds.tpl */

$this->_cache_serials['./Smarty/templates_c/%%F7^F7E^F7E97768%%editrounds.tpl.inc'] = '3d5265eb2606f3860d43ed5849436578';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editrounds.tpl', 21, false),array('function', 'submenulinks', 'editrounds.tpl', 26, false),array('function', 'math', 'editrounds.tpl', 30, false),array('function', 'url', 'editrounds.tpl', 31, false),)), $this); ?>
<?php
function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'managerounds_title'), $_smarty);
}


function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_1(&$_smarty)
{
echo translate_smarty(array('id' => 'manage_event_text'), $_smarty);
}


function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_2(&$_smarty)
{
echo translate_smarty(array('id' => 'print_score_cards_help'), $_smarty);
}


function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_3(&$_smarty)
{
echo url_smarty(array('page' => 'printscorecard','round' => $_smarty->_tpl_vars['roundnum'],'id' => $_GET['id']), $_smarty);
}


function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_4(&$_smarty)
{
echo translate_smarty(array('id' => 'round_number','number' => $_smarty->_tpl_vars['roundnum']), $_smarty);
}


function _smarty_tplfunc_3d5265eb2606f3860d43ed5849436578_5(&$_smarty)
{
echo translate_smarty(array('id' => 'preliminary'), $_smarty);
}



?>
