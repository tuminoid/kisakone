<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:24
         compiled from redirect.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'redirect.tpl', 23, false),array('modifier', 'escape', 'redirect.tpl', 31, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%77^770^770CF2DB%%redirect.tpl.inc'] = '5869ee6f0a11d0638914e7236bad9064'; ?> <?php if ($this->_tpl_vars['type'] == 'login'): ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5869ee6f0a11d0638914e7236bad9064#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'loginredirect_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5869ee6f0a11d0638914e7236bad9064#0}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5869ee6f0a11d0638914e7236bad9064#1}'; endif;echo translate_smarty(array('assign' => 'text','id' => 'loginredirect_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5869ee6f0a11d0638914e7236bad9064#1}'; endif;?>

<?php $this->assign('url', $_SERVER['REQUEST_URI']); ?>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><?php echo $this->_tpl_vars['text']; ?>
</p>

<p><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5869ee6f0a11d0638914e7236bad9064#2}'; endif;echo translate_smarty(array('id' => 'redirect_proceed'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5869ee6f0a11d0638914e7236bad9064#2}'; endif;?>
</a></p>

<script type="text/javascript">
//<![CDATA[
var url = "<?php echo ((is_array($_tmp=$this->_tpl_vars['url'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
<?php echo '

setTimeout(doRedirect, 3000);

function doRedirect() {
    window.location = url;
}

'; ?>

//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>