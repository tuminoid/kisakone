<?php /* Smarty version 2.6.26, created on 2010-03-06 10:37:47
         compiled from changepassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'changepassword.tpl', 22, false),array('function', 'formerror', 'changepassword.tpl', 48, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%D5^D55^D556538A%%changepassword.tpl.inc'] = 'ae6d5b9013c1c55df82a50de9e6e741c'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#0}'; endif;echo translate_smarty(array('id' => 'changepassword_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<p><?php if ($_GET['mode'] == recover): ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#1}'; endif;echo translate_smarty(array('id' => 'recover_password_help_final'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#1}'; endif;?>

    <?php else: ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#2}'; endif;echo translate_smarty(array('id' => 'change_password_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#2}'; endif;?>

    <?php endif; ?>
</p>

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="changepassword" />
    
    <div>
	<?php if ($_GET['mode'] == recover): ?>
	    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#3}'; endif;echo translate_smarty(array('id' => 'recovering_password_for','username' => $this->_tpl_vars['username']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#3}'; endif;?>
</p>
	<?php else: ?>
        <label for="current"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#4}'; endif;echo translate_smarty(array('id' => 'old_password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#4}'; endif;?>
</label>
        <?php if (! $this->_tpl_vars['adminmode']): ?>
        <input id="current" type="password" name="current" autocomplete="off" />
        <?php else: ?>
        <input id="current" type="text" disabled="disabled" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#5}'; endif;echo translate_smarty(array('id' => 'admin_changing_password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#5}'; endif;?>
" />        

        <?php endif; ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#6}'; endif;echo formerror_smarty(array('field' => 'current_password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#6}'; endif;?>

	<?php endif; ?>
    </div>
    <div>
        <label for="password1"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#7}'; endif;echo translate_smarty(array('id' => 'new_password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#7}'; endif;?>
</label>
        <input type="password" id="password1" name="password"  autocomplete="off"  />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#8}'; endif;echo formerror_smarty(array('field' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#8}'; endif;?>

    </div>
    <div>
        <label for="password2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#9}'; endif;echo translate_smarty(array('id' => 'password_repeat'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#9}'; endif;?>
</label>
        <input type="password" name="password2"  autocomplete="off"  />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#10}'; endif;echo formerror_smarty(array('field' => 'password2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#10}'; endif;?>

    </div>
    
    <hr />
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#11}'; endif;echo translate_smarty(array('id' => 'form_accept'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#11}'; endif;?>
" name="register" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ae6d5b9013c1c55df82a50de9e6e741c#12}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ae6d5b9013c1c55df82a50de9e6e741c#12}'; endif;?>
" name="cancel" />
            </div>
</form>

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'regform\', \'current\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'password\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'password2\', RepeatedPasswordField, "password1");$
    
    $("#cancelButton").click(CancelSubmit);
    
});


'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>