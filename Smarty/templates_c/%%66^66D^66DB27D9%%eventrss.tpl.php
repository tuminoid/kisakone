<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:49
         compiled from eventrss.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventrss.tpl', 24, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%66^66D^66DB27D9%%eventrss.tpl.inc'] = 'b155d3237a683ce8723d98597ac0c0d3'; ?><rss version="2.0">
    <channel>
        <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b155d3237a683ce8723d98597ac0c0d3#0}'; endif;echo translate_smarty(array('id' => 'eventrss_title','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b155d3237a683ce8723d98597ac0c0d3#0}'; endif;?>
</title>
        <link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
        <description><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b155d3237a683ce8723d98597ac0c0d3#1}'; endif;echo translate_smarty(array('id' => 'eventrss_description','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b155d3237a683ce8723d98597ac0c0d3#1}'; endif;?>
</description>
        <language><?php echo $this->_tpl_vars['language']; ?>
</language>
        <generator>Kisakone 1.0 EventRSS</generator>
        <copyright><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b155d3237a683ce8723d98597ac0c0d3#2}'; endif;echo translate_smarty(array('id' => 'rss_copyright'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b155d3237a683ce8723d98597ac0c0d3#2}'; endif;?>
</copyright>
        <image>
            <url>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/logo2.png</url>
            <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b155d3237a683ce8723d98597ac0c0d3#3}'; endif;echo translate_smarty(array('id' => 'eventrss_title','eventname' => $this->_tpl_vars['event']->name,'eventvenue' => $this->_tpl_vars['event']->venue), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b155d3237a683ce8723d98597ac0c0d3#3}'; endif;?>
</title>
            <link>http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $this->_tpl_vars['url_base']; ?>
event/<?php echo $this->_tpl_vars['event']->id; ?>
</link>
        </image>
        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <?php if ($this->_tpl_vars['item'] !== null): ?>
                <item>
                    <?php ob_start(); ?>rss/<?php echo $this->_tpl_vars['item']['template']; ?>
.tpl<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('filename', ob_get_contents());ob_end_clean(); ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['filename'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </item>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>        
    </channel>
    
</rss>