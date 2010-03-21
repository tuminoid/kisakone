<?php /* Smarty version 2.6.26, created on 2010-02-16 14:52:29
         compiled from support/roundselection.tpl */

$this->_cache_serials['./Smarty/templates_c/%%6E^6EC^6ECDE677%%roundselection.tpl.inc'] = 'e5d31e02d67890be3fa84cf5c5f556e2';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/roundselection.tpl', 22, false),array('function', 'initializeGetFormFields', 'support/roundselection.tpl', 26, false),array('function', 'html_options', 'support/roundselection.tpl', 28, false),)), $this); ?>
<?php
function _smarty_tplfunc_e5d31e02d67890be3fa84cf5c5f556e2_0(&$_smarty)
{
echo translate_smarty(array('assign' => 'title','id' => 'roundselection_title'), $_smarty);
}


function _smarty_tplfunc_e5d31e02d67890be3fa84cf5c5f556e2_1(&$_smarty)
{
echo initializeGetFormFields_Smarty(array('round' => false), $_smarty);
}


function _smarty_tplfunc_e5d31e02d67890be3fa84cf5c5f556e2_2(&$_smarty)
{
echo translate_smarty(array('id' => 'select_round'), $_smarty);
}


function _smarty_tplfunc_e5d31e02d67890be3fa84cf5c5f556e2_3(&$_smarty)
{
echo translate_smarty(array('id' => 'select'), $_smarty);
}



?>
