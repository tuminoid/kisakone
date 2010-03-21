<?php /* Smarty version 2.6.26, created on 2010-02-16 14:47:50
         compiled from eventviews/newsarchive.tpl */ ?>
 <?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>

<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'eventviews/newsitem.tpl', 'smarty_include_vars' => array('item' => $this->_tpl_vars['item'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endforeach; endif; unset($_from); ?>


<?php endif; ?>