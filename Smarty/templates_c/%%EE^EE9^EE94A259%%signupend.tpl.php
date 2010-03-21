<?php /* Smarty version 2.6.26, created on 2010-02-19 00:49:46
         compiled from rss/signupend.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'rss/signupend.tpl', 24, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%EE^EE9^EE94A259%%signupend.tpl.inc'] = '0e01f3d2cee181bf24160cb827ca972e'; ?> <?php ob_start(); ?>rss_<?php echo $this->_tpl_vars['item']['type']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('titleid', ob_get_contents());ob_end_clean(); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['titleid']; ?>
_text<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('textid', ob_get_contents());ob_end_clean(); ?>
<title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0e01f3d2cee181bf24160cb827ca972e#0}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['titleid'],'arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0e01f3d2cee181bf24160cb827ca972e#0}'; endif;?>
</title>
<description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0e01f3d2cee181bf24160cb827ca972e#1}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['textid'],'arguments' => $this->_tpl_vars['item']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0e01f3d2cee181bf24160cb827ca972e#1}'; endif;?>
</description>
<pubDate><?php echo $this->_tpl_vars['item']['rssDate']; ?>
</pubDate>
<?php if ($this->_tpl_vars['item']['link']): ?>
<link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
/signupinfo</link>
<?php endif; ?>
<guid><?php echo $this->_tpl_vars['item']['type']; ?>
</guid>