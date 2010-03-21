<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:08
         compiled from include/footer.tpl */ ?>
</td>
<td id="helpcontainer" <?php if (! $_GET['showhelp']): ?>style="display: none"<?php endif; ?>><?php if ($_GET['showhelp']): ?>
<?php ob_start(); ?>help/<?php echo $this->_tpl_vars['helpfile']; ?>
.tpl<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('fullhelpfile', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['fullhelpfile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?></td>
<?php if (! $this->_tpl_vars['noad'] && ! $_GET['showhelp'] && $this->_tpl_vars['ad'] && $this->_tpl_vars['ad']->type != 'disabled'): ?>
<td id="adbannercontainer">
     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/adbanner.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</td>
<?php endif; ?>
</tr>
</table>
</body>
</html>