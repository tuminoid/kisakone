<?php /* Smarty version 2.6.26, created on 2010-03-20 10:07:28
         compiled from editemail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editemail.tpl', 24, false),array('modifier', 'escape', 'editemail.tpl', 35, false),array('modifier', 'nl2br', 'editemail.tpl', 47, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%98^980^980B4BED%%editemail.tpl.inc'] = '7918ad3a39b54fd611f9d7527a791430'; ?>
<?php if (! $this->_tpl_vars['inline']): ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editcontentpage_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<div style="float: left; max-width: 300px; background-color: #DDD; margin: 8px;">
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#1}'; endif;echo translate_smarty(array('id' => 'email_token_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#1}'; endif;?>
</p>
    <table>
        <?php $_from = $this->_tpl_vars['tokens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['token'] => $this->_tpl_vars['ignored']):
?>
        <tr>
            <?php ob_start(); ?>email_token_<?php echo $this->_tpl_vars['token']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('description', ob_get_contents());ob_end_clean(); ?>            
            <td><?php echo $this->_tpl_vars['token']; ?>
</td>
            <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#2}'; endif;echo translate_smarty(array('id' => ((is_array($_tmp=$this->_tpl_vars['description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#2}'; endif;?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table>
</div>

<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php endif; ?>

<?php if ($_REQUEST['preview']): ?>

<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['preview_email']->text)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>


<?php endif; ?>

<?php if (! $this->_tpl_vars['inline']): ?>
<form method="post" class="evenform" id="form">
<?php endif; ?>
<table class="narrow"><tr><td style="padding-right: 32px">

 <?php if (! $this->_tpl_vars['inline']): ?>
    <input type="hidden" name="formid" value="edit_global_page" />
<?php endif; ?>
    <input type="hidden" name="mode" value="email" />

    <div>
        <label for="title"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#3}'; endif;echo translate_smarty(array('id' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#3}'; endif;?>
</label>
        <input id="title" type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['page']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />        
            
    </div>
    
    <div>
        <label for="textcontent"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#4}'; endif;echo translate_smarty(array('id' => 'content'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#4}'; endif;?>
</label><br />
        <textarea id="textcontent" rows="20" name="textcontent" cols="80"><?php echo ((is_array($_tmp=$this->_tpl_vars['page']->content)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
        <br />
    </div>
    
  
    <hr />
    <div>
        <?php if (! $this->_tpl_vars['save_text']): ?>
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#5}'; endif;echo translate_smarty(array('assign' => 'save_text','id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#5}'; endif;?>

        <?php endif; ?>
        <input type="submit" value="<?php echo $this->_tpl_vars['save_text']; ?>
" name="save" />
        <input id="previewbutton" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#6}'; endif;echo translate_smarty(array('id' => 'form_preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#6}'; endif;?>
" name="preview" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7918ad3a39b54fd611f9d7527a791430#7}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7918ad3a39b54fd611f9d7527a791430#7}'; endif;?>
" name="cancel" />
        
       
    </div>    




<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'form\', \'title\', NonEmptyField, null);    
    
    
});



'; ?>



//]]>
</script>
</td></tr></table>

<?php if (! $this->_tpl_vars['inline']): ?>
</form>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>