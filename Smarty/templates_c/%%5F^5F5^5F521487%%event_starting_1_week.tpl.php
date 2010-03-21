<?php /* Smarty version 2.6.26, created on 2010-02-20 15:18:52
         compiled from rss/event_starting_1_week.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/event_starting_1_week.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%5F^5F5^5F521487%%event_starting_1_week.tpl.inc'] = '28645887d6ff270d5e9ae4b9099064e9'; ?> <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:28645887d6ff270d5e9ae4b9099064e9#0}'; endif;echo translate_smarty(array('id' => 'rss_event_in_1_week'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:28645887d6ff270d5e9ae4b9099064e9#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:28645887d6ff270d5e9ae4b9099064e9#1}'; endif;echo translate_smarty(array('id' => 'rss_event_in_1_week_text','arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:28645887d6ff270d5e9ae4b9099064e9#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
<guid>1-week-to-event</guid>