<?php /* Smarty version 2.6.26, created on 2010-02-17 19:16:49
         compiled from edittournament.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'edittournament.tpl', 41, false),array('function', 'formerror', 'edittournament.tpl', 53, false),array('function', 'html_options', 'edittournament.tpl', 65, false),array('modifier', 'escape', 'edittournament.tpl', 52, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%9C^9CE^9CEE1763%%edittournament.tpl.inc'] = '6bcc16a3b5f1e02f97b53cdb157cc24c'; ?> <?php ob_start(); ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	mode : "textareas",
	plugins : "table",
	theme_advanced_buttons3_add : "tablecontrols",
        theme_advanced_toolbar_location : "top", 

        theme_advanced_toolbar_align : "left", 

        theme_advanced_statusbar_location : "bottom", 

        theme_advanced_resizing : true
});
</script>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('extrahead', ob_get_contents());ob_end_clean(); ?> 
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'edittournament_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#1}'; endif;echo translate_smarty(array('id' => 'edittournament_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#1}'; endif;?>
</h2>

     <input type="hidden" name="formid" value="edit_tournament" />
    
    <div>
        <label for="name"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#2}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#2}'; endif;?>
</label>
        <input id="name" type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#3}'; endif;echo formerror_smarty(array('field' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#3}'; endif;?>

    </div>
    
    <div>
        <label for="year"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#4}'; endif;echo translate_smarty(array('id' => 'year'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#4}'; endif;?>
</label>
        <input id="year" type="text" name="year" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->year)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#5}'; endif;echo formerror_smarty(array('field' => 'year'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#5}'; endif;?>

    </div>
    
    <div>
        <label for="scoreCalculationMethod"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#6}'; endif;echo translate_smarty(array('id' => 'scorecalculation'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#6}'; endif;?>
</label>
        <select id="scoreCalculationMethod" name="scoreCalculationMethod">            
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['scoreOptions'],'selected' => $this->_tpl_vars['tournament']->scoreCalculationMethod), $this);?>

        </select>
    </div>
    
    <div>
        <label for="level"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#7}'; endif;echo translate_smarty(array('id' => 'level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#7}'; endif;?>
</label>
        <select id="level" name="level">            
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['levelOptions'],'selected' => $this->_tpl_vars['tournament']->level), $this);?>

        </select>
    </div>
    
    <div>
        <input type="checkbox" id="available" name="available" <?php if ($this->_tpl_vars['tournament']->available || $_GET['id'] == 'new'): ?> checked="checked" <?php endif; ?>
        />
        <label class="checkboxlabel" for="available"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#8}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#8}'; endif;?>
</label>
    </div>
    




<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'form\', \'name\', NonEmptyField, null);
    CheckedFormField(\'form\', \'year\', PositiveIntegerField, null);
    
    $("#cancelButton").click(CancelSubmit);
    
});


'; ?>



//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
<?php if ($_GET['id'] != 'new'): ?>
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#9}'; endif;echo translate_smarty(array('id' => 'delete_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#9}'; endif;?>
</h2>
    
    <?php if ($this->_tpl_vars['deletable']): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#10}'; endif;echo translate_smarty(array('id' => 'can_delete_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#10}'; endif;?>
</p>
        <p><input type="submit" name="delete" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#11}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#11}'; endif;?>
" /></p>
    <?php else: ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#12}'; endif;echo translate_smarty(array('id' => 'cant_delete_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#12}'; endif;?>
</p>
    <?php endif; ?>
<?php endif; ?>

</td></tr></table>
<div><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#13}'; endif;echo translate_smarty(array('id' => 'description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#13}'; endif;?>
</div>
<textarea name="description" cols="80" rows="20"><?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->description)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>

<hr />
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#14}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#14}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#15}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6bcc16a3b5f1e02f97b53cdb157cc24c#15}'; endif;?>
" name="cancel" />
        
    </div>    

</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 