<?php /* Smarty version 2.6.26, created on 2010-02-09 12:50:37
         compiled from recover_password_info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'recover_password_info.tpl', 22, false),array('function', 'url', 'recover_password_info.tpl', 34, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%D4^D4D^D4D6A0CA%%recover_password_info.tpl.inc'] = 'd6ae3d12758a7d3e5d563ad8ba118e17'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#0}'; endif;echo translate_smarty(array('id' => 'recoverpassword_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($_GET['failed']): ?>
<p class="error">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#1}'; endif;echo translate_smarty(array('id' => 'error_invalid_token'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#1}'; endif;?>

</p>
<?php endif; ?>

<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#2}'; endif;echo translate_smarty(array('id' => 'recover_password_done'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#2}'; endif;?>
</p>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#3}'; endif;echo translate_smarty(array('id' => 'recover_password_done2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#3}'; endif;?>
</p>

<form method="GET" class="evenform" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#4}'; endif;echo url_smarty(array('page' => 'changepassword','id' => $_GET['id'],'mode' => 'recover'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#4}'; endif;?>
">    
    <div>
        <label for="token"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#5}'; endif;echo translate_smarty(array('id' => 'passwordtoken'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#5}'; endif;?>
</label>
        <input type="text" name="token" value="" />
    </div>
    
    <p>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:d6ae3d12758a7d3e5d563ad8ba118e17#6}'; endif;echo translate_smarty(array('id' => 'proceed'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:d6ae3d12758a7d3e5d563ad8ba118e17#6}'; endif;?>
" />
        
    </p>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 