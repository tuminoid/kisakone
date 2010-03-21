<?php /* Smarty version 2.6.26, created on 2010-02-15 18:31:19
         compiled from error.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'error.tpl', 22, false),array('modifier', 'escape', 'error.tpl', 32, false),array('modifier', 'nl2br', 'error.tpl', 41, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%67^67E^67E1C58E%%error.tpl.inc'] = 'fcd7ba3fd4f44cdc54bfb23027ff0a6e'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#0}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['error']->title,'assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#1}'; endif;echo translate_smarty(array('id' => 'error_occured'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#1}'; endif;?>
</p>
<p><?php echo $this->_tpl_vars['error']->description; ?>
</p>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#2}'; endif;echo translate_smarty(array('id' => 'error_nowwhat'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:fcd7ba3fd4f44cdc54bfb23027ff0a6e#2}'; endif;?>
</p>

<?php if ($this->_tpl_vars['admin']): ?>
    <table class="narrow error">
        <tr>
            <td>Cause</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['error']->cause)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
        <tr>
            <td>InternalDescription</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['error']->internalDescription)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
        <tr>
            <td>Function</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['error']->function)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
        <tr>
            <td>Backtrace</td><td><pre><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['backtrace'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</pre></td>
        </tr>
    </table>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 