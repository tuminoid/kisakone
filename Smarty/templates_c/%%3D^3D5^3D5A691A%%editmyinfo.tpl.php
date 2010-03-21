<?php /* Smarty version 2.6.26, created on 2010-02-15 16:10:36
         compiled from editmyinfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editmyinfo.tpl', 22, false),array('function', 'formerror', 'editmyinfo.tpl', 34, false),array('function', 'html_select_date', 'editmyinfo.tpl', 65, false),array('modifier', 'escape', 'editmyinfo.tpl', 33, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%3D^3D5^3D5A691A%%editmyinfo.tpl.inc'] = '1816168db8fc7f7dfcffa70d8df51335'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#0}'; endif;echo translate_smarty(array('id' => 'editmyinfo_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="post" class="evenform" id="regform">
    
    <input type="hidden" name="formid" value="editmyinfo" />
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#1}'; endif;echo translate_smarty(array('id' => 'reg_contact_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#1}'; endif;?>
</h2>    
    
    <div>
        <label for="lastname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#2}'; endif;echo translate_smarty(array('id' => 'last_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#2}'; endif;?>
</label>
        <input id="lastname" type="text" name="lastname" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#3}'; endif;echo formerror_smarty(array('field' => 'lastname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#3}'; endif;?>

    </div>
    <div>
        <label for="firstname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#4}'; endif;echo translate_smarty(array('id' => 'first_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#4}'; endif;?>
</label>
        <input id="firstname" type="text" name="firstname"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#5}'; endif;echo formerror_smarty(array('field' => 'firstname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#5}'; endif;?>

    </div>
    <div>
        <label for="email"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#6}'; endif;echo translate_smarty(array('id' => 'reg_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#6}'; endif;?>
</label>
        <input id="email" type="text" name="email"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->email)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#7}'; endif;echo formerror_smarty(array('field' => 'email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#7}'; endif;?>

    </div>
    
    <?php if ($this->_tpl_vars['player']): ?>
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#8}'; endif;echo translate_smarty(array('id' => 'reg_player_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#8}'; endif;?>
</h2>
     <div>
        <label for="pdga"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#9}'; endif;echo translate_smarty(array('id' => 'pdga_number'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#9}'; endif;?>
</label>
        <input id="pdga" type="text" name="pdga"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#10}'; endif;echo formerror_smarty(array('field' => 'pdga'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#10}'; endif;?>

    </div>
     
     <div>
        <label for="gender"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#11}'; endif;echo translate_smarty(array('id' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#11}'; endif;?>
</label>
        <input id="gender" type="radio" name="gender" value="M" <?php if ($this->_tpl_vars['player']->gender == 'M'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#12}'; endif;echo translate_smarty(array('id' => 'male'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#12}'; endif;?>
 &nbsp;&nbsp;
        <input type="radio" name="gender" value="F" <?php if ($this->_tpl_vars['player']->gender == 'F'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#13}'; endif;echo translate_smarty(array('id' => 'female'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#13}'; endif;?>

        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#14}'; endif;echo formerror_smarty(array('field' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#14}'; endif;?>

    </div>
     
     <div>
        <label><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#15}'; endif;echo translate_smarty(array('id' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#15}'; endif;?>
</label>        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#16}'; endif;echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#16}'; endif;?>

        <?php echo smarty_function_html_select_date(array('time' => $this->_tpl_vars['dob'],'field_order' => 'DMY','month_format' => "%m",'prefix' => 'dob_','display_months' => false,'display_days' => false,'start_year' => '1900','year_empty' => $this->_tpl_vars['year_default'],'month_empty' => $this->_tpl_vars['month_default'],'day_empty' => $this->_tpl_vars['day_default'],'field_separator' => ' ','all_extra' => 'style="min-width: 0"'), $this);?>

        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#17}'; endif;echo formerror_smarty(array('field' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#17}'; endif;?>

    </div>
     <?php endif; ?>
         <hr />    
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#18}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#18}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:1816168db8fc7f7dfcffa70d8df51335#19}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1816168db8fc7f7dfcffa70d8df51335#19}'; endif;?>
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
    CheckedFormField(\'regform\', \'pdga\', PositiveIntegerField, null);
    CheckedFormField(\'regform\', \'gender\', RadioFieldSet, null);
    CheckedFormField(\'regform\', \'dob_Year\', NonEmptyField, null);
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