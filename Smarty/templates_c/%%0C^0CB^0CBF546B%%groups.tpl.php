<?php /* Smarty version 2.6.26, created on 2010-02-13 13:10:33
         compiled from rss/groups.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/groups.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%0C^0CB^0CBF546B%%groups.tpl.inc'] = '297257adb357ac9239d3408f506a0567'; ?><title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:297257adb357ac9239d3408f506a0567#0}'; endif;echo translate_smarty(array('id' => 'rss_groups_finished','round' => $this->_tpl_vars['item']['roundNum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:297257adb357ac9239d3408f506a0567#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:297257adb357ac9239d3408f506a0567#1}'; endif;echo translate_smarty(array('id' => 'rss_groups_finished_text','round' => $this->_tpl_vars['item']['roundNum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:297257adb357ac9239d3408f506a0567#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
/schedule/<?php echo $this->_tpl_vars['item']['roundNum']; ?>
</link>
<guid><?php echo $this->_tpl_vars['item']['type']; ?>
_<?php echo $this->_tpl_vars['item']['roundNum']; ?>
</guid>