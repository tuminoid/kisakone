<?php /* Smarty version 2.6.26, created on 2010-02-01 16:13:38
         compiled from help/users.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'helplink', 'help/users.tpl', 3, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%D1^D11^D11CA3C8%%users.tpl.inc'] = '41118f2e7d01205e9ebed9da04d77c43'; ?><?php if ($this->_tpl_vars['language'] == 'fi-FI'): ?>
<p>käyttäjäsivun ohje</p>
<p>Linkki: <?php if ($this->caching && !$this->_cache_including): echo '{nocache:41118f2e7d01205e9ebed9da04d77c43#0}'; endif;echo helplink_smarty(array('page' => 'events','title' => 'kilpailuihin'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:41118f2e7d01205e9ebed9da04d77c43#0}'; endif;?>
</p>
<?php endif; ?>