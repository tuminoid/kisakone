<?php /* Smarty version 2.6.26, created on 2010-02-16 14:40:11
         compiled from editclass.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editclass.tpl', 22, false),array('function', 'formerror', 'editclass.tpl', 34, false),array('function', 'html_options', 'editclass.tpl', 51, false),array('modifier', 'escape', 'editclass.tpl', 33, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%67^674^67461357%%editclass.tpl.inc'] = 'e26993a9303581d73f3c44c63d0b417e'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editclass_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#1}'; endif;echo translate_smarty(array('id' => 'editclass_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#1}'; endif;?>
</h2>

    <input type="hidden" name="formid" value="edit_class" />
    
    <div>
        <label for="Name"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#2}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#2}'; endif;?>
</label>
        <input type="text" id="Name" name="Name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['class']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#3}'; endif;echo formerror_smarty(array('field' => 'Name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#3}'; endif;?>

    </div>
    
    <div>
        <label for="MinimumAge"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#4}'; endif;echo translate_smarty(array('id' => 'minage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#4}'; endif;?>
</label>
        <input type="text" id="MinimumAge" name="MinimumAge" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['class']->minAge)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#5}'; endif;echo formerror_smarty(array('field' => 'MinimumAge'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#5}'; endif;?>

    </div>
    <div>
        <label for="MaximumAge"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#6}'; endif;echo translate_smarty(array('id' => 'maxage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#6}'; endif;?>
</label>
        <input type="text" id="MaximumAge" name="MaximumAge" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['class']->maxAge)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#7}'; endif;echo formerror_smarty(array('field' => 'MaximumAge'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#7}'; endif;?>

    </div>
    
    <div>
        <label for="GenderRequirement"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#8}'; endif;echo translate_smarty(array('id' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#8}'; endif;?>
</label>
        <select name="GenderRequirement" id="GenderRequirement">            
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['genderOptions'],'selected' => $this->_tpl_vars['class']->gender), $this);?>

        </select>

    </div>
    
    <div>
        <input type="checkbox" id="Available" name="Available" <?php if ($this->_tpl_vars['class']->available || $_GET['id'] == 'new'): ?> checked="checked" <?php endif; ?>
        />
        <label class="checkboxlabel" for="Available"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#9}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#9}'; endif;?>
</label>
    </div>
<hr />
<div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#10}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#10}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#11}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#11}'; endif;?>
" name="cancel" />
        
    </div>    



<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'form\', \'Name\', NonEmptyField, null);
    CheckedFormField(\'form\', \'MinimumAge\', PositiveIntegerField, true);
    CheckedFormField(\'form\', \'MaximumAge\', PositiveIntegerField, true);
    
    $("#cancelButton").click(CancelSubmit);
    
});


'; ?>



//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
<?php if ($_GET['id'] != 'new'): ?>
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#12}'; endif;echo translate_smarty(array('id' => 'delete_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#12}'; endif;?>
</h2>
    
    <?php if ($this->_tpl_vars['deletable']): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#13}'; endif;echo translate_smarty(array('id' => 'can_delete_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#13}'; endif;?>
</p>
        <p><input type="submit" name="delete" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#14}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#14}'; endif;?>
" /></p>
    <?php else: ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e26993a9303581d73f3c44c63d0b417e#15}'; endif;echo translate_smarty(array('id' => 'cant_delete_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e26993a9303581d73f3c44c63d0b417e#15}'; endif;?>
</p>
    <?php endif; ?>
<?php endif; ?>

</td></tr></table>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 