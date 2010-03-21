<?php /* Smarty version 2.6.26, created on 2010-02-16 14:55:43
         compiled from printscorecard.tpl */

$this->_cache_serials['./Smarty/templates_c/%%F8^F80^F80A6B68%%printscorecard.tpl.inc'] = 'c0cb67562d500d93bcb0322048a76f86';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'printscorecard.tpl', 27, false),array('function', 'math', 'printscorecard.tpl', 97, false),array('function', 'initializeGetFormFields', 'printscorecard.tpl', 106, false),array('function', 'counter', 'printscorecard.tpl', 119, false),array('modifier', 'escape', 'printscorecard.tpl', 113, false),array('modifier', 'date_format', 'printscorecard.tpl', 125, false),)), $this); ?>
<?php
function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_0(&$_smarty)
{
echo translate_smarty(array('id' => 'site_name'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_1(&$_smarty)
{
echo initializeGetFormFields_Smarty(array('signature' => false,'perpage' => false), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_2(&$_smarty)
{
echo translate_smarty(array('id' => 'scorecard_sign_help'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_3(&$_smarty)
{
echo translate_smarty(array('id' => 'signature_none'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_4(&$_smarty)
{
echo translate_smarty(array('id' => 'signature_column'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_5(&$_smarty)
{
echo translate_smarty(array('id' => 'signature_row'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_6(&$_smarty)
{
echo translate_smarty(array('id' => 'scorecard_perpage'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_7(&$_smarty)
{
echo translate_smarty(array('id' => 'update'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_8(&$_smarty)
{
echo translate_smarty(array('id' => 'round_number','number' => $_smarty->_tpl_vars['round']->roundNumber), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_9(&$_smarty)
{
echo translate_smarty(array('id' => 'group_number','number' => $_smarty->_tpl_vars['firstgroup']['PoolNumber']), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_10(&$_smarty)
{
echo translate_smarty(array('id' => 'group_starting','start' => $_smarty->_tpl_vars['groupstart']), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_11(&$_smarty)
{
echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $_smarty->_tpl_vars['firstgroup']['StartingHole']), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_12(&$_smarty)
{
echo translate_smarty(array('id' => 'hole_num'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_13(&$_smarty)
{
echo translate_smarty(array('id' => 'hole_out'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_14(&$_smarty)
{
echo translate_smarty(array('id' => 'hole_in'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_15(&$_smarty)
{
echo translate_smarty(array('id' => 'total'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_16(&$_smarty)
{
echo translate_smarty(array('id' => 'signature'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_17(&$_smarty)
{
echo translate_smarty(array('id' => 'hole_par'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_18(&$_smarty)
{
echo translate_smarty(array('id' => 'hole_length'), $_smarty);
}


function _smarty_tplfunc_c0cb67562d500d93bcb0322048a76f86_19(&$_smarty)
{
echo translate_smarty(array('id' => 'signature'), $_smarty);
}



?>
