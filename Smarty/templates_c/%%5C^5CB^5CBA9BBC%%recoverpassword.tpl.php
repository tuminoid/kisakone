<?php /* Smarty version 2.6.26, created on 2010-02-19 13:53:03
         compiled from recoverpassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'recoverpassword.tpl', 22, false),array('modifier', 'escape', 'recoverpassword.tpl', 38, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%5C^5CB^5CBA9BBC%%recoverpassword.tpl.inc'] = '7f1534ba81dabfb1d16c96c3e5b581b2'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7f1534ba81dabfb1d16c96c3e5b581b2#0}'; endif;echo translate_smarty(array('id' => 'recoverpassword_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7f1534ba81dabfb1d16c96c3e5b581b2#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php if ($this->_tpl_vars['failedAlready']): ?>
    <p class="error"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7f1534ba81dabfb1d16c96c3e5b581b2#1}'; endif;echo translate_smarty(array('id' => 'error_no_such_user'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7f1534ba81dabfb1d16c96c3e5b581b2#1}'; endif;?>
</p>
<?php endif; ?>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7f1534ba81dabfb1d16c96c3e5b581b2#2}'; endif;echo translate_smarty(array('id' => 'recover_password_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7f1534ba81dabfb1d16c96c3e5b581b2#2}'; endif;?>
</p>

<form method="post" class="evenform">
    
    <input type="hidden" name="formid" value="recover_password" />
    
    <div>
        <label for="username"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7f1534ba81dabfb1d16c96c3e5b581b2#3}'; endif;echo translate_smarty(array('id' => 'username_or_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7f1534ba81dabfb1d16c96c3e5b581b2#3}'; endif;?>
</label>
        <input id="username" type="text" name="username" value="<?php echo ((is_array($_tmp=$_POST['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
    </div>
    
    <p>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7f1534ba81dabfb1d16c96c3e5b581b2#4}'; endif;echo translate_smarty(array('id' => 'recover'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7f1534ba81dabfb1d16c96c3e5b581b2#4}'; endif;?>
" />
        
    </p>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 