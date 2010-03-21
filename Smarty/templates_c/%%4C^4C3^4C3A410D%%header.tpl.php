<?php /* Smarty version 2.6.26, created on 2010-02-15 16:26:49
         compiled from include/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'include/header.tpl', 27, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%4C^4C3^4C3A410D%%header.tpl.inc'] = 'dc8b3e6d951d0e301b8534c0c8fb1716'; ?><!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <title><?php echo $this->_tpl_vars['title']; ?>
 - <?php if ($this->caching && !$this->_cache_including): echo '{nocache:dc8b3e6d951d0e301b8534c0c8fb1716#0}'; endif;echo translate_smarty(array('id' => 'site_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:dc8b3e6d951d0e301b8534c0c8fb1716#0}'; endif;?>
</title>
      <link rel="stylesheet" href="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/style.css" type="text/css" />
      <script type="text/javascript" src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/jquery-1.3.2.min.js"></script>      
      <script type="text/javascript" src="<?php echo $this->_tpl_vars['url_base']; ?>
javascript/base"></script>
      <?php if ($this->_tpl_vars['autocomplete']): ?>
      <script type="text/javascript" src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/jquery.autocomplete-min.js"></script>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['ui']): ?>
      <script type="text/javascript" src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/jquery-ui-1.7.2.custom.min.js"></script>
      <link rel="stylesheet" href="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/jquery-ui-1.7.2.custom.css" type="text/css" />
      <meta http-equiv="Content-Type" content="<?php echo $this->_tpl_vars['contentType']; ?>
" />
      <?php endif; ?>
      <?php echo $this->_tpl_vars['extrahead']; ?>

</head>
<body>
<table id="contentcontainer">
      <tr id="headtr">
            <td colspan="3">
            
      <div id="header">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/loginbox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php if ($_GET['languagebar']): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/languagebar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
      <img id="sitelogo" src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/logo2.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:dc8b3e6d951d0e301b8534c0c8fb1716#1}'; endif;echo translate_smarty(array('id' => 'site_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:dc8b3e6d951d0e301b8534c0c8fb1716#1}'; endif;?>
" />
      
      <h1 id="sitename"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:dc8b3e6d951d0e301b8534c0c8fb1716#2}'; endif;echo translate_smarty(array('id' => 'site_name_long'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:dc8b3e6d951d0e301b8534c0c8fb1716#2}'; endif;?>
</h1>
      <div id="pagename"><?php echo $this->_tpl_vars['title']; ?>
</div>
      </div>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/mainmenu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td></tr>
    <tr id="maintr2">
        <td id="submenucontainer">        <br />
            <?php echo $this->_tpl_vars['submenu_content']; ?>

            
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/submenu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </td>        
        <td id="content">
            <ul class="breadcrumb">
                  <?php if ($this->_tpl_vars['mainmenuselection'] != 'unique'): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/breadcrumb.tpl", 'smarty_include_vars' => array('from' => $this->_tpl_vars['submenu'][$this->_tpl_vars['mainmenuselection']])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                  <?php else: ?>
                        <li><?php echo $this->_tpl_vars['title']; ?>
</li>
                  <?php endif; ?>
            </ul>
            <br style="clear: left" />
