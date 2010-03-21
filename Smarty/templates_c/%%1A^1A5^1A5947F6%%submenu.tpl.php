<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from include/submenu.tpl */ ?>
<?php if ($this->_tpl_vars['mainmenuselection'] != 'unique'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/submenulevel.tpl', 'smarty_include_vars' => array('items' => $this->_tpl_vars['submenu'][$this->_tpl_vars['mainmenuselection']]['children'],'depth' => 0)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
    <ul class="submenu submenu0">
        <li><span><?php echo $this->_tpl_vars['title']; ?>
</span></li>
    </ul>
<?php endif; ?>
