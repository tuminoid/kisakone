<?php /* Smarty version 2.6.26, created on 2010-02-18 07:42:24
         compiled from editcustomeventpages.tpl */

$this->_cache_serials['./Smarty/templates_c/%%DA^DA3^DA3D7839%%editcustomeventpages.tpl.inc'] = 'a689bf307090bfe2482921edb91d5604';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editcustomeventpages.tpl', 25, false),array('function', 'url', 'editcustomeventpages.tpl', 30, false),array('modifier', 'escape', 'editcustomeventpages.tpl', 30, false),)), $this); ?>
<?php
function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_0(&$_smarty)
{
echo translate_smarty(array('id' => 'eventpages_custom_main_text'), $_smarty);
}


function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_1(&$_smarty)
{
echo url_smarty(array('arguments' => $_smarty->_tpl_vars['link']['link']), $_smarty);
}


function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_2(&$_smarty)
{
echo translate_smarty(array('id' => 'no_content'), $_smarty);
}


function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_3(&$_smarty)
{
echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'mode' => 'custom','content' => "*"), $_smarty);
}


function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_4(&$_smarty)
{
echo translate_smarty(array('id' => 'create_new_custom_page_link'), $_smarty);
}


function _smarty_tplfunc_a689bf307090bfe2482921edb91d5604_5(&$_smarty)
{
echo translate_smarty(array('id' => 'create_new_custom_page_text','link' => $_smarty->_tpl_vars['link']), $_smarty);
}



?>
