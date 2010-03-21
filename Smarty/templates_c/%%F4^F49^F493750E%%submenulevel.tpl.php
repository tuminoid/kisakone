<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from include/submenulevel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'include/submenulevel.tpl', 27, false),array('modifier', 'escape', 'include/submenulevel.tpl', 30, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%F4^F49^F493750E%%submenulevel.tpl.inc'] = 'c3d6741f17a497411b59f7c6dc8afc71'; ?> <ul class="submenu submenu<?php echo $this->_tpl_vars['depth']; ?>
">    
    <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <?php if (access ( $this->_tpl_vars['item']['access'] ) && $this->_tpl_vars['item']['condition']): ?>
            <li>
                <?php if (! $this->_tpl_vars['item']['selected']): ?>
                    <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:c3d6741f17a497411b59f7c6dc8afc71#0}'; endif;echo url_smarty(array('arguments' => $this->_tpl_vars['item']['link']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c3d6741f17a497411b59f7c6dc8afc71#0}'; endif;?>
">
                <?php endif; ?>
               
                <span><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>        
                <?php if (! $this->_tpl_vars['item']['selected']): ?>
                    </a>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['item']['open']): ?>
                    <?php if (count ( $this->_tpl_vars['item']['children'] ) != 0): ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/submenulevel.tpl', 'smarty_include_vars' => array('items' => $this->_tpl_vars['item']['children'],'depth' => ($this->_tpl_vars['depth']+1))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
                <?php endif; ?>
            </li><?php else: ?>
        <?php endif; ?>
    
    <?php endforeach; endif; unset($_from); ?>
    
</ul>&nbsp;