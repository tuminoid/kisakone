<?php /* Smarty version 2.6.26, created on 2010-02-15 15:56:43
         compiled from autocomplete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'autocomplete.tpl', 26, false),)), $this); ?>
{
    query:"<?php echo $this->_tpl_vars['query']; ?>
",
    suggestions:[
        <?php $_from = $this->_tpl_vars['suggestions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['suggestions'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['suggestions']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['suggestion']):
        $this->_foreach['suggestions']['iteration']++;
?>
            <?php if (! ($this->_foreach['suggestions']['iteration'] <= 1)): ?>, <?php endif; ?>
            "<?php echo ((is_array($_tmp=$this->_tpl_vars['suggestion'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"
        <?php endforeach; endif; unset($_from); ?>
    ]
    <?php if ($this->_tpl_vars['data']): ?>
    ,
    data:[
        <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['data']['iteration']++;
?>
            <?php if (! ($this->_foreach['data']['iteration'] <= 1)): ?>, <?php endif; ?>
            "<?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
"
        <?php endforeach; endif; unset($_from); ?>
    ]
    <?php endif; ?>
}