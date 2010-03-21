<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:50
         compiled from rss/event_will_start.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/event_will_start.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%62^62A^62A4CFA4%%event_will_start.tpl.inc'] = 'd749dfd611b188189db9a4e805e8d522'; ?><title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d749dfd611b188189db9a4e805e8d522#0}'; endif;echo translate_smarty(array('id' => 'rss_event_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d749dfd611b188189db9a4e805e8d522#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d749dfd611b188189db9a4e805e8d522#1}'; endif;echo translate_smarty(array('id' => 'rss_event_start_text','arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d749dfd611b188189db9a4e805e8d522#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
<guid>event-start-date</guid>