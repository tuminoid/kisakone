<?php /* Smarty version 2.6.26, created on 2010-03-20 11:17:13
         compiled from remind.tpl */

$this->_cache_serials['./Smarty/templates_c/%%74^746^7460B6C7%%remind.tpl.inc'] = '94acc4ba1851e3ee376634c300fc6672';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'remind.tpl', 22, false),array('function', 'url', 'remind.tpl', 28, false),array('modifier', 'escape', 'remind.tpl', 30, false),)), $this); ?>
<?php
function _smarty_tplfunc_94acc4ba1851e3ee376634c300fc6672_0(&$this)
{
echo translate_smarty(array('assign' => 'title','id' => 'send_reminds_title'), $this);
}


function _smarty_tplfunc_94acc4ba1851e3ee376634c300fc6672_1(&$this)
{
echo translate_smarty(array('assign' => 'save_text','id' => 'send_email'), $this);
}


function _smarty_tplfunc_94acc4ba1851e3ee376634c300fc6672_2(&$this)
{
echo translate_smarty(array('id' => 'sending_email_to','recipients' => $this->_tpl_vars['numReminds']), $this);
}


function _smarty_tplfunc_94acc4ba1851e3ee376634c300fc6672_3(&$this)
{
echo url_smarty(array('page' => 'remind','id' => $_GET['id']), $this);
}



?>
