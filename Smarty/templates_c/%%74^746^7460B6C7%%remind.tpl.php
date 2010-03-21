<?php /* Smarty version 2.6.26, created on 2010-03-20 11:17:13
         compiled from remind.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'remind.tpl', 22, false),array('function', 'url', 'remind.tpl', 28, false),array('modifier', 'escape', 'remind.tpl', 30, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%74^746^7460B6C7%%remind.tpl.inc'] = '94acc4ba1851e3ee376634c300fc6672'; ?> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:94acc4ba1851e3ee376634c300fc6672#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'send_reminds_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:94acc4ba1851e3ee376634c300fc6672#0}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:94acc4ba1851e3ee376634c300fc6672#1}'; endif;echo translate_smarty(array('assign' => 'save_text','id' => 'send_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:94acc4ba1851e3ee376634c300fc6672#1}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:94acc4ba1851e3ee376634c300fc6672#2}'; endif;echo translate_smarty(array('id' => 'sending_email_to','recipients' => $this->_tpl_vars['numReminds']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:94acc4ba1851e3ee376634c300fc6672#2}'; endif;?>
</p>

<form method="post" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:94acc4ba1851e3ee376634c300fc6672#3}'; endif;echo url_smarty(array('page' => 'remind','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:94acc4ba1851e3ee376634c300fc6672#3}'; endif;?>
">
<input type="hidden" name="formid" value="remind" />
<input type="hidden" name="ids" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['idlist'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'editemail.tpl', 'smarty_include_vars' => array('inline' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>