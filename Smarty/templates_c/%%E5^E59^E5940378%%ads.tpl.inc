<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:29
         compiled from ads.tpl */

$this->_cache_serials['./Smarty/templates_c/%%E5^E59^E5940378%%ads.tpl.inc'] = 'f8aadb8aa5f3405a29fcfc4f360b19eb';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'ads.tpl', 22, false),array('function', 'url', 'ads.tpl', 37, false),)), $this); ?>
<?php
function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_0(&$this)
{
echo translate_smarty(array('assign' => 'title','id' => 'ads_title'), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_1(&$this)
{
echo translate_smarty(array('id' => 'ad_location'), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_2(&$this)
{
echo translate_smarty(array('id' => 'ad_type'), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_3(&$this)
{
echo translate_smarty(array('id' => 'ad_actions'), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_4(&$this)
{
echo translate_smarty(array('id' => $this->_tpl_vars['locid']), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_5(&$this)
{
echo translate_smarty(array('id' => $this->_tpl_vars['typeid']), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_6(&$this)
{
echo url_smarty(array('page' => 'editad','adType' => $this->_tpl_vars['ad']->contentId), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_7(&$this)
{
echo translate_smarty(array('id' => 'edit'), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_8(&$this)
{
echo url_smarty(array('page' => 'editad','adType' => $this->_tpl_vars['ad']->contentId,'preview' => 1), $this);
}


function _smarty_tplfunc_f8aadb8aa5f3405a29fcfc4f360b19eb_9(&$this)
{
echo translate_smarty(array('id' => 'preview'), $this);
}



?>
