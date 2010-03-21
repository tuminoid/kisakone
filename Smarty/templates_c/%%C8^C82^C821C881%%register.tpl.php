<?php /* Smarty version 2.6.26, created on 2010-02-16 14:17:11
         compiled from register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'register.tpl', 22, false),array('function', 'formerror', 'register.tpl', 34, false),array('function', 'html_select_date', 'register.tpl', 85, false),array('function', 'url', 'register.tpl', 95, false),array('modifier', 'escape', 'register.tpl', 33, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C8^C82^C821C881%%register.tpl.inc'] = '9716f6edcd79a43b420fae55bc5e58ae'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#0}'; endif;echo translate_smarty(array('id' => 'register_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="register" />
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#1}'; endif;echo translate_smarty(array('id' => 'reg_contact_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#1}'; endif;?>
</h2>    
    
    <div>
        <label for="lastname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#2}'; endif;echo translate_smarty(array('id' => 'last_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#2}'; endif;?>
</label>
        <input id="lastname" type="text" name="lastname" value="<?php echo ((is_array($_tmp=$_POST['lastname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#3}'; endif;echo formerror_smarty(array('field' => 'lastname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#3}'; endif;?>

    </div>
    <div>
        <label for="firstname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#4}'; endif;echo translate_smarty(array('id' => 'first_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#4}'; endif;?>
</label>
        <input id="firstname" type="text" name="firstname"  value="<?php echo ((is_array($_tmp=$_POST['firstname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#5}'; endif;echo formerror_smarty(array('field' => 'firstname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#5}'; endif;?>

    </div>
    <div>
        <label for="email"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#6}'; endif;echo translate_smarty(array('id' => 'reg_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#6}'; endif;?>
</label>
        <input id="email" type="text" name="email"  value="<?php echo ((is_array($_tmp=$_POST['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#7}'; endif;echo formerror_smarty(array('field' => 'email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#7}'; endif;?>

    </div>
    
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#8}'; endif;echo translate_smarty(array('id' => 'reg_user_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#8}'; endif;?>
</h2>
    <div>
        <label for="username"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#9}'; endif;echo translate_smarty(array('id' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#9}'; endif;?>
</label>
        <input id="username" type="text" name="username"  value="<?php echo ((is_array($_tmp=$_POST['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#10}'; endif;echo formerror_smarty(array('field' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#10}'; endif;?>

    </div>
    <div>
        <label for="password1"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#11}'; endif;echo translate_smarty(array('id' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#11}'; endif;?>
</label>
        <input type="password" id="password1" name="password" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#12}'; endif;echo formerror_smarty(array('field' => 'password'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#12}'; endif;?>

    </div>
    <div>
        <label for="password2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#13}'; endif;echo translate_smarty(array('id' => 'password_repeat'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#13}'; endif;?>
</label>
        <input id="password2" type="password" name="password2" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#14}'; endif;echo formerror_smarty(array('field' => 'password2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#14}'; endif;?>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#15}'; endif;echo translate_smarty(array('id' => 'reg_player_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#15}'; endif;?>
</h2>
     <div>
        <label for="pdga"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#16}'; endif;echo translate_smarty(array('id' => 'pdga_number'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#16}'; endif;?>
</label>
        <input id="pdga" type="text" name="pdga"  value="<?php echo ((is_array($_tmp=$_POST['pdga'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#17}'; endif;echo formerror_smarty(array('field' => 'pdga'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#17}'; endif;?>

    </div>
     
     <div>
        <label for="gender"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#18}'; endif;echo translate_smarty(array('id' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#18}'; endif;?>
</label>
        <input id="gender" type="radio" name="gender" value="male" <?php if ($_POST['gender'] == 'male'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#19}'; endif;echo translate_smarty(array('id' => 'male'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#19}'; endif;?>
 &nbsp;&nbsp;
        <input type="radio" name="gender" value="female" <?php if ($_POST['gender'] == 'female'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#20}'; endif;echo translate_smarty(array('id' => 'female'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#20}'; endif;?>

        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#21}'; endif;echo formerror_smarty(array('field' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#21}'; endif;?>

    </div>
     
     <div style="margin-top: 8px">
        <label><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#22}'; endif;echo translate_smarty(array('id' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#22}'; endif;?>
</label>
        <!--<select  style="min-width: 0" name="day">
            <option value="" selected="true">pp</option>
        </select>-->
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#23}'; endif;echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#23}'; endif;?>

        <?php echo smarty_function_html_select_date(array('time' => '1980-1-1','field_order' => 'DMY','month_format' => "%m",'prefix' => 'dob_','start_year' => '1900','display_months' => false,'display_days' => false,'year_empty' => $this->_tpl_vars['year_default'],'month_empty' => $this->_tpl_vars['month_default'],'day_empty' => $this->_tpl_vars['day_default'],'field_separator' => ' ','all_extra' => 'style="min-width: 0"'), $this);?>

        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#24}'; endif;echo formerror_smarty(array('field' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#24}'; endif;?>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#25}'; endif;echo translate_smarty(array('id' => 'reg_termsandconditions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#25}'; endif;?>
</h2>
    <div>
        <input type="checkbox" id="termsandconditions" name="termsandconditions" <?php if ($_POST['termsandconditions']): ?>checked="checked"<?php endif; ?> />
        <?php ob_start(); ?>
        <a target="_blank" href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#26}'; endif;echo url_smarty(array('page' => 'termsandconditions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#26}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#27}'; endif;echo translate_smarty(array('id' => 'termsandconditionslinktitle'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#27}'; endif;?>
</a>
           <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('termslink', ob_get_contents());ob_end_clean(); ?>
        <label class="checkboxlabel" for="termsandconditions"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#28}'; endif;echo translate_smarty(array('id' => 'termsandconditions','link' => $this->_tpl_vars['termslink']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#28}'; endif;?>
</label>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#29}'; endif;echo formerror_smarty(array('field' => 'termsandconditions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#29}'; endif;?>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#30}'; endif;echo translate_smarty(array('id' => 'reg_finalize'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#30}'; endif;?>
</h2>
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#31}'; endif;echo translate_smarty(array('id' => 'form_accept'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#31}'; endif;?>
" name="register" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#32}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#32}'; endif;?>
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
    CheckedFormField(\'regform\', \'gender\', RadioFieldSet, null);
    CheckedFormField(\'regform\', \'dob_Year\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'termsandconditions\', TermsAndConditionsField, null);
    
    $("#cancelButton").click(CancelSubmit);
    
});

function TermsAndConditionsField(field, arguments, initialize) {
    if (!initialize) {	
	if (field.get()[0].checked) return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:9716f6edcd79a43b420fae55bc5e58ae#33}'; endif;echo translate_smarty(array('id' => 'FormError_Terms','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9716f6edcd79a43b420fae55bc5e58ae#33}'; endif;?>
";
	<?php echo '
    }
    
}

'; ?>



//]]>
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>