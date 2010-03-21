<?php /* Smarty version 2.6.26, created on 2010-01-30 09:24:41
         compiled from help.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'help.tpl', 13, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%41^416^416864CF%%help.tpl.inc'] = '257205f6372f78638e0ff11630a04fc3'; ?><?php if ($_GET['inline']): ?>
<?php echo '<?xml'; ?>
 version="1.0" <?php echo '?>'; ?>

<div>
<?php ob_start(); ?>help/<?php echo $this->_tpl_vars['helpfile']; ?>
.tpl<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('fullhelpfile', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['fullhelpfile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php else: ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:257205f6372f78638e0ff11630a04fc3#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'help_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:257205f6372f78638e0ff11630a04fc3#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php ob_start(); ?>help/<?php echo $this->_tpl_vars['helpfile']; ?>
.tpl<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('fullhelpfile', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['fullhelpfile'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
    //<![CDATA[
    <?php echo '
$("document").ready(function() {
   $("#helplink").parent().remove();
   $("#helpcontainer").remove();
   DisplayHelp = DisplayHelp_Local;
    
});

function DisplayHelp_Local(helpfile) {
    alert(\'x\');
    //document.location = "http://10.0.0.12";
}
'; ?>


// ]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>