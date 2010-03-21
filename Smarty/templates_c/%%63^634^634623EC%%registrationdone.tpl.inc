<?php /* Smarty version 2.6.26, created on 2010-02-15 16:07:00
         compiled from registrationdone.tpl */

$this->_cache_serials['./Smarty/templates_c/%%63^634^634623EC%%registrationdone.tpl.inc'] = 'e857db1224490bc5e8cfe69cff43d46b';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'registrationdone.tpl', 22, false),)), $this); ?>
<?php
function _smarty_tplfunc_e857db1224490bc5e8cfe69cff43d46b_0(&$this)
{
echo translate_smarty(array('assign' => 'title','id' => 'registration_done_title'), $this);
}


function _smarty_tplfunc_e857db1224490bc5e8cfe69cff43d46b_1(&$this)
{
echo translate_smarty(array('id' => 'cookiewarning'), $this);
}


function _smarty_tplfunc_e857db1224490bc5e8cfe69cff43d46b_2(&$this)
{
echo translate_smarty(array('id' => 'registration_done_main_text','username' => $this->_tpl_vars['user']->username), $this);
}



?>
