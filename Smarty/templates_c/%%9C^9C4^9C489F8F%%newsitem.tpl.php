<?php /* Smarty version 2.6.26, created on 2010-02-18 10:38:51
         compiled from eventviews/newsitem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'eventviews/newsitem.tpl', 24, false),)), $this); ?>
 <?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <h3><?php echo $this->_tpl_vars['item']->title; ?>
</h3>
<div><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M:%S")); ?>
</div>
<div><?php echo $this->_tpl_vars['item']->content; ?>
</div>

<?php endif; ?>