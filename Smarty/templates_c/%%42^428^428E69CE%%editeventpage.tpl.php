<?php /* Smarty version 2.6.26, created on 2010-02-16 13:09:28
         compiled from editeventpage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editeventpage.tpl', 41, false),array('modifier', 'escape', 'editeventpage.tpl', 51, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%42^428^428E69CE%%editeventpage.tpl.inc'] = '38a474a454cc019c8fff8a4821501680'; ?><?php ob_start(); ?>
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
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editcontentpage_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php endif; ?>

<?php if ($_POST['preview']): ?>

<?php if ($_GET['mode'] == 'news'): ?>
<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['page']->GetProperTitle())) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
<?php endif; ?>
<?php echo $this->_tpl_vars['page']->formattedText; ?>

<hr />
<?php endif; ?>

<form method="post" class="evenform" id="form">
<table class="narrow"><tr><td style="padding-right: 32px">

        <?php if ($this->_tpl_vars['global']): ?>
        <input type="hidden" name="formid" value="edit_global_page" />
        <?php else: ?>
     <input type="hidden" name="formid" value="edit_event_page" />
    <?php endif; ?>
    <?php if (! $this->_tpl_vars['global'] || $this->_tpl_vars['custom']): ?>
    <div>
        <label for="title"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#1}'; endif;echo translate_smarty(array('id' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#1}'; endif;?>
</label>
        <input id="title" type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['page']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />        
        
        <?php if ($_GET['mode'] != custom && $_GET['mode'] != news): ?>
        <?php ob_start(); ?>pagetitle_<?php echo $this->_tpl_vars['page']->type; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('transkey', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#2}'; endif;echo translate_smarty(array('assign' => 'pagetitle','id' => $this->_tpl_vars['transkey']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#2}'; endif;?>

        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#3}'; endif;echo translate_smarty(array('id' => 'default_title_for_page','title' => $this->_tpl_vars['pagetitle']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#3}'; endif;?>
</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <div class="yui-skin-sam">
        <label for="textcontent"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#4}'; endif;echo translate_smarty(array('id' => 'content'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#4}'; endif;?>
</label><br />
        <textarea id="textcontent" rows="20" name="textcontent" cols="120"><?php echo ((is_array($_tmp=$this->_tpl_vars['page']->content)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
        <br />
    </div>
    
    <?php if ($this->_tpl_vars['global'] && $_GET['mode'] == custom): ?>
        <div>
            <label for="access"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#5}'; endif;echo translate_smarty(array('id' => 'content_access'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#5}'; endif;?>
</label><br />
            <select name="type" id="access">
                <option value="custom" <?php if ($this->_tpl_vars['page']->type == custom): ?>selected="selected"<?php endif; ?>><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#6}'; endif;echo translate_smarty(array('id' => 'access_all'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#6}'; endif;?>
</option>
                <option value="custom_man" <?php if ($this->_tpl_vars['page']->type == 'custom_man'): ?>selected="selected"<?php endif; ?>><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#7}'; endif;echo translate_smarty(array('id' => 'access_management'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#7}'; endif;?>
</option>
                <option value="custom_adm" <?php if ($this->_tpl_vars['page']->type == 'custom_adm'): ?>selected="selected"<?php endif; ?>><?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#8}'; endif;echo translate_smarty(array('id' => 'access_admin'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#8}'; endif;?>
</option>
            </select>
        </div>
    <?php endif; ?>
  
    <hr />
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#9}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#9}'; endif;?>
" name="save" />
        <input id="previewbutton" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#10}'; endif;echo translate_smarty(array('id' => 'form_preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#10}'; endif;?>
" name="preview" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#11}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#11}'; endif;?>
" name="cancel" />
        
        <?php if ($_GET['content'] != '*'): ?>
        <input style="margin-left: 60px;" type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:38a474a454cc019c8fff8a4821501680#12}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:38a474a454cc019c8fff8a4821501680#12}'; endif;?>
" name="delete" />
        
        <?php endif; ?>
    </div>    




<script type="text/javascript">
//<![CDATA[
<?php if ($_GET['mode'] == 'custom'): ?>
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'form\', \'name\', NonEmptyField, null);
    
    
    $("#cancelButton").click(CancelSubmit);
    
    
});



'; ?>

<?php endif; ?>


//]]>
</script>
</td></tr></table>
</form>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>