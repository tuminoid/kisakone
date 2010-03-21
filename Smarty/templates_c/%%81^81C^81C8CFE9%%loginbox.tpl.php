<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:07
         compiled from include/loginbox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'include/loginbox.tpl', 24, false),array('function', 'translate', 'include/loginbox.tpl', 24, false),array('modifier', 'escape', 'include/loginbox.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%81^81C^81C8CFE9%%loginbox.tpl.inc'] = '2927a3ca7af64d7402c599f4a163df2a'; ?><?php if ($this->_tpl_vars['user'] == null): ?>
<div class="loginbox" id="login_panel">
    <a id="login_link" href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#0}'; endif;echo url_smarty(array('page' => 'login'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#0}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#1}'; endif;echo translate_smarty(array('id' => 'login'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#1}'; endif;?>
</a> |
    <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#2}'; endif;echo url_smarty(array('page' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#2}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#3}'; endif;echo translate_smarty(array('id' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#3}'; endif;?>
</a>
 
</div>
<form class="loginbox hidden" action="<?php echo $this->_tpl_vars['url_base']; ?>
" id="login_form" method="post">
    <input type="hidden" name="comingFrom" value="<?php echo ((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
    <a id="loginform_x" href="" class="dialogx" ><img src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/loginx2.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#4}'; endif;echo translate_smarty(array('id' => 'close'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#4}'; endif;?>
" /></a>
    <input type="hidden" name="loginAt" value="<?php echo time(); ?>
" />
    <input type="hidden" name="formid" value="login" />    
    <div>
        <label for="loginUsernameInput"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#5}'; endif;echo translate_smarty(array('id' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#5}'; endif;?>
</label>
        <input type="text" name="username" id="loginUsernameInput" />
    </div>
    <div>
        <label for="loginPassword"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#6}'; endif;echo translate_smarty(array('id' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#6}'; endif;?>
</label>
        <input type="password" id="loginPassword" name="password" />
    </div>
    
    <div>
        <input type="checkbox" name="rememberMe" /> Muista salasana
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#7}'; endif;echo translate_smarty(array('id' => 'loginbutton'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#7}'; endif;?>
" />                
    </div>
    <div>
        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#8}'; endif;echo url_smarty(array('page' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#9}'; endif;echo translate_smarty(array('id' => 'register'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#9}'; endif;?>
</a> |
        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#10}'; endif;echo url_smarty(array('page' => 'recoverpassword'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#10}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#11}'; endif;echo translate_smarty(array('id' => 'forgottenpassword'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#11}'; endif;?>
</a>
    </div>
</form>
<?php else: ?>
    <div class="loginbox">
    <div><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#12}'; endif;echo translate_smarty(array('id' => 'loginform_loggedin_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#12}'; endif;?>
</div>
    <div><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#13}'; endif;echo translate_smarty(array('id' => 'loginform_loggedin_as','user' => $this->_tpl_vars['user']->username,'firstname' => $this->_tpl_vars['user']->firstname,'lastname' => $this->_tpl_vars['user']->lastname), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#13}'; endif;?>
</div>
    <p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#14}'; endif;echo url_smarty(array('page' => 'myinfo'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#15}'; endif;echo translate_smarty(array('id' => 'my_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#15}'; endif;?>
</a> |  <a href="<?php echo $this->_tpl_vars['url_base']; ?>
?action=logout"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2927a3ca7af64d7402c599f4a163df2a#16}'; endif;echo translate_smarty(array('id' => 'logout'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2927a3ca7af64d7402c599f4a163df2a#16}'; endif;?>
</a></p>
    </div>
<?php endif; ?>
    