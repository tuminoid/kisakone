<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:13
         compiled from event.tpl */ ?>
 <?php ob_start(); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['view'], 'smarty_include_vars' => array('mode' => 'head')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('extrahead', ob_get_contents());ob_end_clean(); ?>
 <?php ob_start(); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['view'], 'smarty_include_vars' => array('mode' => 'body')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('view_content', ob_get_contents());ob_end_clean(); ?>
<?php ob_start(); ?><?php echo $this->_tpl_vars['page']->title; ?>
 - <?php echo $this->_tpl_vars['event']->name; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('title', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('ui' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['view_content']; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>