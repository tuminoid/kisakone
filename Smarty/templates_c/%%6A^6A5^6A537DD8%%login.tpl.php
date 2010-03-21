<?php /* Smarty version 2.6.26, created on 2010-02-16 12:45:26
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'login.tpl', 22, false),array('function', 'url', 'login.tpl', 53, false),array('modifier', 'escape', 'login.tpl', 39, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6A^6A5^6A537DD8%%login.tpl.inc'] = '7672f398bbc969f1a5b0febda93ed3c4'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#0}'; endif;echo translate_smarty(array('id' => 'login_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#1}'; endif;echo translate_smarty(array('id' => 'loginform_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#1}'; endif;?>
</h2>

<?php if ($this->_tpl_vars['failedAlready']): ?>
    <p class="error"><?php echo $this->_tpl_vars['errorMessage']; ?>

        </p>
<?php endif; ?>

<form method="post" class="evenform">
    
    <input type="hidden" name="formid" value="login" />
    <input type="hidden" name="loginAt" value="<?php echo time(); ?>
" />
    
    <div>
        <label for="f_username"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#2}'; endif;echo translate_smarty(array('id' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#2}'; endif;?>
</label>
        <input id="f_username" type="text" name="username" value="<?php echo ((is_array($_tmp=$_POST['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
    </div>
    <div>
        <label for="f_password"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#3}'; endif;echo translate_smarty(array('id' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#3}'; endif;?>
</label>
        <input id="f_password" type="password" name="password" />
    </div>
    
    <div>        
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#4}'; endif;echo translate_smarty(array('id' => 'loginbutton'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#4}'; endif;?>
" />                
    </div>
    <div>
    <input type="checkbox" name="rememberMe" /> Muista salasana
    </div>
    <p>
        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#5}'; endif;echo url_smarty(array('page' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#5}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#6}'; endif;echo translate_smarty(array('id' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#6}'; endif;?>
</a>
        | <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#7}'; endif;echo url_smarty(array('page' => 'recoverpassword'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#7}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7672f398bbc969f1a5b0febda93ed3c4#8}'; endif;echo translate_smarty(array('id' => 'forgottenpassword'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7672f398bbc969f1a5b0febda93ed3c4#8}'; endif;?>
</a>
    </p>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 