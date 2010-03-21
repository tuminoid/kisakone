<?php /* Smarty version 2.6.26, created on 2010-02-15 15:55:52
         compiled from editlevel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editlevel.tpl', 22, false),array('function', 'formerror', 'editlevel.tpl', 34, false),array('function', 'html_options', 'editlevel.tpl', 40, false),array('modifier', 'escape', 'editlevel.tpl', 33, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%32^32F^32F68438%%editlevel.tpl.inc'] = 'f6f2d0df51d627a15402121b4ad892da'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editlevel_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">
<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#1}'; endif;echo translate_smarty(array('id' => 'editlevel_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#1}'; endif;?>
</h2>

    <input type="hidden" name="formid" value="edit_level" />
    
    <div>
        <label for="name"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#2}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#2}'; endif;?>
</label>
        <input id="name" type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['level']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#3}'; endif;echo formerror_smarty(array('field' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#3}'; endif;?>

    </div>
    
    <div>
        <label for="scoreCalculationMethod"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#4}'; endif;echo translate_smarty(array('id' => 'scorecalculation'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#4}'; endif;?>
</label>
        <select id="scoreCalculationMethod" name="scoreCalculationMethod">            
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['scoreOptions'],'selected' => $this->_tpl_vars['level']['scoreCalculationMethod']), $this);?>

        </select>
    </div>
    
    
    <div>
        <input type="checkbox" id="available" name="available" <?php if ($this->_tpl_vars['level']['available'] || $_GET['id'] == 'new'): ?> checked="checked" <?php endif; ?>
        />
        <label class="checkboxlabel" for="available"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#5}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#5}'; endif;?>
</label>
    </div>
<hr />
<div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#6}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#6}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#7}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#7}'; endif;?>
" name="cancel" />
        
    </div>    



<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'form\', \'Name\', NonEmptyField, null);
    
    $("#cancelButton").click(CancelSubmit);
    
});


'; ?>



//]]>
</script>
</td><td style="border-left: 1px dotted #AAA; padding-left: 32px;">
<?php if ($_GET['id'] != 'new'): ?>
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#8}'; endif;echo translate_smarty(array('id' => 'delete_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#8}'; endif;?>
</h2>
    
    <?php if ($this->_tpl_vars['deletable']): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#9}'; endif;echo translate_smarty(array('id' => 'can_delete_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#9}'; endif;?>
</p>
        <p><input type="submit" name="delete" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#10}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#10}'; endif;?>
" /></p>
    <?php else: ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f6f2d0df51d627a15402121b4ad892da#11}'; endif;echo translate_smarty(array('id' => 'cant_delete_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f6f2d0df51d627a15402121b4ad892da#11}'; endif;?>
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