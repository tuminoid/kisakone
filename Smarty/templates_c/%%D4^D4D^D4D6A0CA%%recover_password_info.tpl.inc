<?php /* Smarty version 2.6.26, created on 2010-02-09 12:50:37
         compiled from recover_password_info.tpl */

$this->_cache_serials['./Smarty/templates_c/%%D4^D4D^D4D6A0CA%%recover_password_info.tpl.inc'] = 'd6ae3d12758a7d3e5d563ad8ba118e17';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'recover_password_info.tpl', 22, false),array('function', 'url', 'recover_password_info.tpl', 34, false),)), $this); ?>
<?php
function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_0(&$this)
{
echo translate_smarty(array('id' => 'recoverpassword_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_1(&$this)
{
echo translate_smarty(array('id' => 'error_invalid_token'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_2(&$this)
{
echo translate_smarty(array('id' => 'recover_password_done'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_3(&$this)
{
echo translate_smarty(array('id' => 'recover_password_done2'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_4(&$this)
{
echo url_smarty(array('page' => 'changepassword','id' => $_GET['id'],'mode' => 'recover'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_5(&$this)
{
echo translate_smarty(array('id' => 'passwordtoken'), $this);
}


function _smarty_tplfunc_d6ae3d12758a7d3e5d563ad8ba118e17_6(&$this)
{
echo translate_smarty(array('id' => 'proceed'), $this);
}



?>
