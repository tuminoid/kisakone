<?php /* Smarty version 2.6.26, created on 2010-02-13 13:10:33
         compiled from rss/event_start_today.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/event_start_today.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C3^C35^C350BCB7%%event_start_today.tpl.inc'] = '120aee27eb0a6efea07c6d6464c15b9f'; ?> <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:120aee27eb0a6efea07c6d6464c15b9f#0}'; endif;echo translate_smarty(array('id' => 'rss_event_start_today'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:120aee27eb0a6efea07c6d6464c15b9f#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:120aee27eb0a6efea07c6d6464c15b9f#1}'; endif;echo translate_smarty(array('id' => 'rss_event_start_today_text','arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:120aee27eb0a6efea07c6d6464c15b9f#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
<guid>event-start-today</guid>