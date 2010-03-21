<?php /* Smarty version 2.6.26, created on 2010-01-29 18:05:48
         compiled from datagen.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'datagen.tpl', 8, false),array('modifier', 'nl2br', 'datagen.tpl', 8, false),)), $this); ?>
<?php $this->assign('title', 'Datagen'); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style type="text/css">
<?php echo '
.c { margin: 32px; border: 1px solid blue; padding: 16px; }
'; ?>

</style>
<div><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['e'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</div>
<form method="POST">
    <input type="hidden" name="formid" value="datagen" />
    <p class="c">
        Generate players: <input type="text" name="players" value="0" />
    </p>
    <div class="c">
        Increase number of signups to <input type="text" name="numSignups" value="0" />
        <br />
        In event
        <select name="numEvent">
            <?php $_from = $this->_tpl_vars['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?> 
                <option value="<?php echo $this->_tpl_vars['event']->id; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
        </select>
    </div>
    <input type="submit" value="Do it!" />
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>