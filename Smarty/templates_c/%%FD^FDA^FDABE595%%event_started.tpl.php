<?php /* Smarty version 2.6.26, created on 2010-03-05 03:27:55
         compiled from rss/event_started.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/event_started.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%FD^FDA^FDABE595%%event_started.tpl.inc'] = 'f89102fbc04b7fa3ae3748e723396640'; ?> <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f89102fbc04b7fa3ae3748e723396640#0}'; endif;echo translate_smarty(array('id' => 'rss_event_started'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f89102fbc04b7fa3ae3748e723396640#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f89102fbc04b7fa3ae3748e723396640#1}'; endif;echo translate_smarty(array('id' => 'rss_event_started_text','arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f89102fbc04b7fa3ae3748e723396640#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
<guid>event-started</guid>