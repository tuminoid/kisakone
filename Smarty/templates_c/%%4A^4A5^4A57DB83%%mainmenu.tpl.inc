<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:07
         compiled from include/mainmenu.tpl */

$this->_cache_serials['./Smarty/templates_c/%%4A^4A5^4A57DB83%%mainmenu.tpl.inc'] = '1a17a3381032a47c7b91fc59f46a8f5e';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'include/mainmenu.tpl', 28, false),array('function', 'translate', 'include/mainmenu.tpl', 28, false),)), $this); ?>
<?php
function _smarty_tplfunc_1a17a3381032a47c7b91fc59f46a8f5e_0(&$this)
{
echo url_smarty(array('page' => $this->_tpl_vars['mainmenu'][$this->_sections['menuitem']['index']]['url']), $this);
}


function _smarty_tplfunc_1a17a3381032a47c7b91fc59f46a8f5e_1(&$this)
{
echo translate_smarty(array('id' => $this->_tpl_vars['mainmenu'][$this->_sections['menuitem']['index']]['title']), $this);
}



?>
