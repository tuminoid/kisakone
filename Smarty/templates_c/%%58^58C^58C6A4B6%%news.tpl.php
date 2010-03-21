<?php /* Smarty version 2.6.26, created on 2010-02-19 00:49:45
         compiled from rss/news.tpl */ ?>
 <?php ob_start(); ?>rss_<?php echo $this->_tpl_vars['item']['type']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('titleid', ob_get_contents());ob_end_clean(); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['titleid']; ?>
_text<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('textid', ob_get_contents());ob_end_clean(); ?>
<title><?php echo $this->_tpl_vars['item']['title']; ?>
</title>
<description><?php echo $this->_tpl_vars['item']['content']; ?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
/signupinfo</link>
<guid>news_<?php echo $this->_tpl_vars['item']['newsid']; ?>
</guid>