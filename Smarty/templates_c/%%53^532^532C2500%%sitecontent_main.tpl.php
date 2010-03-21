<?php /* Smarty version 2.6.26, created on 2010-02-16 13:09:25
         compiled from sitecontent_main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'sitecontent_main.tpl', 22, false),array('function', 'url', 'sitecontent_main.tpl', 30, false),array('modifier', 'escape', 'sitecontent_main.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%53^532^532C2500%%sitecontent_main.tpl.inc'] = '46fbb514cff5cd22dc907ee83f3a0b28'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'sitecontent_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#1}'; endif;echo translate_smarty(array('id' => 'admin_sitecontent_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#1}'; endif;?>


<table class="oddrows narrow">
    <?php $_from = $this->_tpl_vars['fixed']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
        <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['link']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#2}'; endif;echo url_smarty(array('page' => 'sitecontent','id' => $this->_tpl_vars['link']['type']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#2}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#3}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#3}'; endif;?>
</a></td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#4}'; endif;echo url_smarty(array('page' => 'content','id' => $this->_tpl_vars['link']['type']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#4}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#5}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#5}'; endif;?>
</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#6}'; endif;echo translate_smarty(array('id' => 'sitecontent_custom_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#6}'; endif;?>
</p>

<table class="oddrows narrow">
    <?php $_from = $this->_tpl_vars['dynamic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
        <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['link']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#7}'; endif;echo url_smarty(array('page' => 'sitecontent','id' => $this->_tpl_vars['link']['id'],'mode' => 'custom'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#7}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#8}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#8}'; endif;?>
</a></td>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#9}'; endif;echo url_smarty(array('page' => 'content','id' => $this->_tpl_vars['link']['title']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#9}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#10}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#10}'; endif;?>
</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

    

<p>
    <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#11}'; endif;echo url_smarty(array('page' => 'sitecontent','id' => "*",'mode' => 'custom'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#11}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:46fbb514cff5cd22dc907ee83f3a0b28#12}'; endif;echo translate_smarty(array('id' => 'new_page'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:46fbb514cff5cd22dc907ee83f3a0b28#12}'; endif;?>
</a>
</p>
     
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 