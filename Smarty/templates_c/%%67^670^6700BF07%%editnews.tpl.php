<?php /* Smarty version 2.6.26, created on 2010-02-16 14:50:08
         compiled from editnews.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editnews.tpl', 22, false),array('function', 'url', 'editnews.tpl', 26, false),array('modifier', 'escape', 'editnews.tpl', 31, false),array('modifier', 'date_format', 'editnews.tpl', 32, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%67^670^6700BF07%%editnews.tpl.inc'] = '0a5d201b8ebe1e53c148954720b94893'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editnews_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#1}'; endif;echo translate_smarty(array('id' => 'editnews_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#1}'; endif;?>
</h2>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#2}'; endif;echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'content' => "*",'mode' => 'news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#2}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#3}'; endif;echo translate_smarty(array('id' => 'new_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#3}'; endif;?>
</a></p>

<table class="oddrows">
<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <tr>
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#4}'; endif;echo url_smarty(array('page' => 'editeventpage','mode' => 'news','id' => $_GET['id'],'content' => $this->_tpl_vars['item']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#4}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>        
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->date)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M:%S")); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->content)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#5}'; endif;echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'content' => "*",'mode' => 'news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#5}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0a5d201b8ebe1e53c148954720b94893#6}'; endif;echo translate_smarty(array('id' => 'new_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0a5d201b8ebe1e53c148954720b94893#6}'; endif;?>
</a></p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 