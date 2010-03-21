<?php /* Smarty version 2.6.26, created on 2010-02-18 07:42:24
         compiled from editcustomeventpages.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editcustomeventpages.tpl', 25, false),array('function', 'url', 'editcustomeventpages.tpl', 30, false),array('modifier', 'escape', 'editcustomeventpages.tpl', 30, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%DA^DA3^DA3D7839%%editcustomeventpages.tpl.inc'] = 'a689bf307090bfe2482921edb91d5604'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#0}'; endif;echo translate_smarty(array('id' => 'eventpages_custom_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#0}'; endif;?>


<ul>
    <?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
        <li>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#1}'; endif;echo url_smarty(array('arguments' => $this->_tpl_vars['link']['link']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#1}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['link']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
        </li>
        <?php endforeach; else: ?>
        <li><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#2}'; endif;echo translate_smarty(array('id' => 'no_content'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#2}'; endif;?>
</li>
        
    <?php endif; unset($_from); ?>
</ul>

<p>
    <?php ob_start(); ?><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#3}'; endif;echo url_smarty(array('page' => 'editeventpage','id' => $_GET['id'],'mode' => 'custom','content' => "*"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#3}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#4}'; endif;echo translate_smarty(array('id' => 'create_new_custom_page_link'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#4}'; endif;?>
</a><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('link', ob_get_contents());ob_end_clean(); ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:a689bf307090bfe2482921edb91d5604#5}'; endif;echo translate_smarty(array('id' => 'create_new_custom_page_text','link' => $this->_tpl_vars['link']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a689bf307090bfe2482921edb91d5604#5}'; endif;?>

</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>