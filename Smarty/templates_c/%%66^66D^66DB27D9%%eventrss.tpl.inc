<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:49
         compiled from eventrss.tpl */

$this->_cache_serials['./Smarty/templates_c/%%66^66D^66DB27D9%%eventrss.tpl.inc'] = 'b155d3237a683ce8723d98597ac0c0d3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventrss.tpl', 24, false),)), $this); ?>
<?php
function _smarty_tplfunc_b155d3237a683ce8723d98597ac0c0d3_0(&$this)
{
echo translate_smarty(array('id' => 'eventrss_title','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);
}


function _smarty_tplfunc_b155d3237a683ce8723d98597ac0c0d3_1(&$this)
{
echo translate_smarty(array('id' => 'eventrss_description','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);
}


function _smarty_tplfunc_b155d3237a683ce8723d98597ac0c0d3_2(&$this)
{
echo translate_smarty(array('id' => 'rss_copyright'), $this);
}


function _smarty_tplfunc_b155d3237a683ce8723d98597ac0c0d3_3(&$this)
{
echo translate_smarty(array('id' => 'eventrss_title','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);
}



?>
