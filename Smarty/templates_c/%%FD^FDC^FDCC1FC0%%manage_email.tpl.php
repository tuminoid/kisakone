<?php /* Smarty version 2.6.26, created on 2010-03-20 10:05:05
         compiled from manage_email.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manage_email.tpl', 24, false),array('function', 'url', 'manage_email.tpl', 30, false),array('modifier', 'escape', 'manage_email.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%FD^FDC^FDCC1FC0%%manage_email.tpl.inc'] = 'c61d96ba092cd80d64b972fed58f38c7'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:c61d96ba092cd80d64b972fed58f38c7#0}'; endif;echo translate_smarty(array('id' => 'admin_manage_email_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c61d96ba092cd80d64b972fed58f38c7#0}'; endif;?>


<table class="oddrows">
    <?php $_from = $this->_tpl_vars['fixed']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
        <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['link']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:c61d96ba092cd80d64b972fed58f38c7#1}'; endif;echo url_smarty(array('page' => 'editemail','id' => $this->_tpl_vars['link']['type']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c61d96ba092cd80d64b972fed58f38c7#1}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c61d96ba092cd80d64b972fed58f38c7#2}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c61d96ba092cd80d64b972fed58f38c7#2}'; endif;?>
</a></td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:c61d96ba092cd80d64b972fed58f38c7#3}'; endif;echo url_smarty(array('page' => 'editemail','id' => $this->_tpl_vars['link']['type']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c61d96ba092cd80d64b972fed58f38c7#3}'; endif;?>
 preview=1"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c61d96ba092cd80d64b972fed58f38c7#4}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c61d96ba092cd80d64b972fed58f38c7#4}'; endif;?>
</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>


     
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 