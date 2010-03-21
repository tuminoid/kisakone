<?php /* Smarty version 2.6.26, created on 2010-01-30 09:32:39
         compiled from eventviews/newsarchive.tpl */

$this->_cache_serials['./Smarty/templates_c/%%7A^7A6^7A6BCA19%%newsarchive.tpl.inc'] = '0508d2215abcaeec13cbe96d326b60e9';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'eventviews/newsarchive.tpl', 16, false),)), $this); ?>
<?php
function _smarty_tplfunc_0508d2215abcaeec13cbe96d326b60e9_0(&$this)
{
echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'newsarchive','newspage' => $this->_tpl_vars['ind']), $this);
}



?>
