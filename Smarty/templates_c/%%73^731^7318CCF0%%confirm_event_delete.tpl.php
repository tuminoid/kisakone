<?php /* Smarty version 2.6.26, created on 2010-02-15 16:10:49
         compiled from confirm_event_delete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'confirm_event_delete.tpl', 25, false),array('modifier', 'escape', 'confirm_event_delete.tpl', 37, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%73^731^7318CCF0%%confirm_event_delete.tpl.inc'] = '26f8abd82047757b5c62687d49929e3f'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:26f8abd82047757b5c62687d49929e3f#0}'; endif;echo translate_smarty(array('id' => 'confirm_event_delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:26f8abd82047757b5c62687d49929e3f#0}'; endif;?>
</h2>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:26f8abd82047757b5c62687d49929e3f#1}'; endif;echo translate_smarty(array('id' => 'confirm_event_delete_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:26f8abd82047757b5c62687d49929e3f#1}'; endif;?>
</p>

<div style="width: 600px; height: 300px; overflow: scroll; padding: 16px; background-color: #EEE ">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "eventviews/index.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:26f8abd82047757b5c62687d49929e3f#2}'; endif;echo translate_smarty(array('id' => 'confirm_event_delete_question'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:26f8abd82047757b5c62687d49929e3f#2}'; endif;?>
</p>

<form method="post" action="<?php echo $this->_tpl_vars['url_base']; ?>
">
    <input type="hidden" name="formid" value="delete_event" />
    <input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$_GET['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
    <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:26f8abd82047757b5c62687d49929e3f#3}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:26f8abd82047757b5c62687d49929e3f#3}'; endif;?>
" />
    <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:26f8abd82047757b5c62687d49929e3f#4}'; endif;echo translate_smarty(array('id' => 'abort'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:26f8abd82047757b5c62687d49929e3f#4}'; endif;?>
" />
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>