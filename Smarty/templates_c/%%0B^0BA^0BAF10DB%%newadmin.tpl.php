<?php /* Smarty version 2.6.26, created on 2010-02-16 12:45:41
         compiled from newadmin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'newadmin.tpl', 22, false),array('function', 'formerror', 'newadmin.tpl', 40, false),array('modifier', 'escape', 'newadmin.tpl', 39, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%0B^0BA^0BAF10DB%%newadmin.tpl.inc'] = 'b48b1b3f0252e7403efbd280a637c9f3'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#0}'; endif;echo translate_smarty(array('id' => 'newadmin_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['done']): ?>
    <p class="searcharea">
	<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#1}'; endif;echo translate_smarty(array('id' => 'admin_created','username' => $_POST['username']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#1}'; endif;?>

    </p>
<?php endif; ?>

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="add_admin" />
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#2}'; endif;echo translate_smarty(array('id' => 'reg_contact_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#2}'; endif;?>
</h2>    
    
    <div>
        <label for="lastname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#3}'; endif;echo translate_smarty(array('id' => 'last_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#3}'; endif;?>
</label>
        <input id="lastname" type="text" name="lastname" value="<?php if (! $this->_tpl_vars['done']): ?><?php echo ((is_array($_tmp=$_POST['lastname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#4}'; endif;echo formerror_smarty(array('field' => 'lastname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#4}'; endif;?>

    </div>
    <div>
        <label for="firstname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#5}'; endif;echo translate_smarty(array('id' => 'first_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#5}'; endif;?>
</label>
        <input id="firstname" type="text" name="firstname"  value="<?php if (! $this->_tpl_vars['done']): ?><?php echo ((is_array($_tmp=$_POST['firstname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#6}'; endif;echo formerror_smarty(array('field' => 'firstname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#6}'; endif;?>

    </div>
    <div>
        <label  for="email"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#7}'; endif;echo translate_smarty(array('id' => 'reg_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#7}'; endif;?>
</label>
        <input id="email" type="text" name="email"  value="<?php if (! $this->_tpl_vars['done']): ?><?php echo ((is_array($_tmp=$_POST['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#8}'; endif;echo formerror_smarty(array('field' => 'email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#8}'; endif;?>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#9}'; endif;echo translate_smarty(array('id' => 'reg_user_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#9}'; endif;?>
</h2>
    <div>
        <label for="username"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#10}'; endif;echo translate_smarty(array('id' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#10}'; endif;?>
</label>
        <input id="username" type="text" name="username"  value="<?php if (! $this->_tpl_vars['done']): ?><?php echo ((is_array($_tmp=$_POST['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#11}'; endif;echo formerror_smarty(array('field' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#11}'; endif;?>

    </div>
    <div>
        <label for="password1"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#12}'; endif;echo translate_smarty(array('id' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#12}'; endif;?>
</label>
        <input type="password" id="password1" name="password" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#13}'; endif;echo formerror_smarty(array('field' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#13}'; endif;?>

    </div>
    <div>
        <label for="password2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#14}'; endif;echo translate_smarty(array('id' => 'password_repeat'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#14}'; endif;?>
</label>
        <input type="password" name="password2" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#15}'; endif;echo formerror_smarty(array('field' => 'password2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#15}'; endif;?>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#16}'; endif;echo translate_smarty(array('id' => 'user_access_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#16}'; endif;?>
</h2>
    <div>        
        <input type="radio" name="access" value="admin" <?php if (! $this->_tpl_vars['done'] && $_POST['access'] == 'admin'): ?>checked="checked"<?php endif; ?> />
	<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#17}'; endif;echo translate_smarty(array('id' => 'access_level_admin'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#17}'; endif;?>

	    <br />
	    
	<input type="radio" name="access" value="manager" <?php if (! $this->_tpl_vars['done'] && $_POST['access'] == 'manager'): ?>checked="checked"<?php endif; ?> />
	<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#18}'; endif;echo translate_smarty(array('id' => 'access_level_manager'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#18}'; endif;?>

	<br />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#19}'; endif;echo formerror_smarty(array('field' => 'access'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#19}'; endif;?>

    </div>
    
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#20}'; endif;echo translate_smarty(array('id' => 'reg_finalize'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#20}'; endif;?>
</h2>
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#21}'; endif;echo translate_smarty(array('id' => 'form_accept'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#21}'; endif;?>
" name="register" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#22}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#22}'; endif;?>
" name="cancel" />        
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'regform\', \'lastname\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'firstname\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'email\', EmailField, null);
    CheckedFormField(\'regform\', \'username\', AjaxField, \'username\');
    CheckedFormField(\'regform\', \'password\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'password2\', RepeatedPasswordField, "password1");
    CheckedFormField(\'regform\', \'access\', RadioFieldSet, null);
    
    $("#cancelButton").click(CancelSubmit);
    
});

function TermsAndConditionsField(field, arguments, initialize) {
    if (!initialize) {	
	if (field.get()[0].checked) return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b48b1b3f0252e7403efbd280a637c9f3#23}'; endif;echo translate_smarty(array('id' => 'FormError_Terms','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b48b1b3f0252e7403efbd280a637c9f3#23}'; endif;?>
";
	<?php echo '
    }
    
}

'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>