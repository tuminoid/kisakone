<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:32
         compiled from editad.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editad.tpl', 22, false),array('function', 'html_options', 'editad.tpl', 112, false),array('modifier', 'escape', 'editad.tpl', 50, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%D5^D57^D57C7934%%editad.tpl.inc'] = 'e5c576800db88c9c04f36e695e2f0514'; ?> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editad_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#0}'; endif;?>

 <?php ob_start(); ?>
 <style type="text/css"><?php echo '

select, input[type="text"], input[type="file"] {
    min-width: 300px;
}

'; ?>
</style>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('extrahead', ob_get_contents());ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['event']): ?>
    <?php ob_start(); ?>ad_event_location_<?php echo $this->_tpl_vars['ad']->contentId; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
<?php else: ?>
    <?php ob_start(); ?>ad_location_<?php echo $this->_tpl_vars['ad']->contentId; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
<?php endif; ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#1}'; endif;echo translate_smarty(array('assign' => 'typetext','id' => $this->_tpl_vars['locid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#1}'; endif;?>

    
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#2}'; endif;echo translate_smarty(array('id' => 'ad_inline_help','adtype' => $this->_tpl_vars['typetext']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#2}'; endif;?>
</p>

<div class="nojs">
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#3}'; endif;echo translate_smarty(array('id' => 'page_requires_javascript'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#3}'; endif;?>

</div>



<?php if ($this->_tpl_vars['error']): ?>
    <p class="error"><?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
<?php endif; ?>

<div class="jsonly">
<form method="post" enctype="multipart/form-data">
    <input name="formid" type="hidden" value="edit_ad" />
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#4}'; endif;echo translate_smarty(array('id' => 'ad_type_heading'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#4}'; endif;?>
</h2>
    <ul class="nobullets">
        <?php if ($_GET['id'] && $_GET['id'] != 'default'): ?>
            <li><input type="radio" <?php if ($this->_tpl_vars['ad']->type == 'eventdefault'): ?>checked="checked"<?php endif; ?> name="ad_type"
            value="eventdefault" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#5}'; endif;echo translate_smarty(array('id' => 'ad_type_eventdefault'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#5}'; endif;?>
</li>
        <?php endif; ?>
        <li><input type="radio" name="ad_type" <?php if ($this->_tpl_vars['ad']->type == 'default'): ?>checked="checked"<?php endif; ?>
        value="default" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#6}'; endif;echo translate_smarty(array('id' => 'ad_type_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#6}'; endif;?>
</li>
        
        <li><input type="radio" name="ad_type" <?php if ($this->_tpl_vars['ad']->type == 'imageandlink'): ?>checked="checked"<?php endif; ?>
        value="imageandlink" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#7}'; endif;echo translate_smarty(array('id' => 'ad_type_imageandlink'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#7}'; endif;?>
</li>
        
        <li><input type="radio" name="ad_type" <?php if ($this->_tpl_vars['ad']->type == 'html'): ?>checked="checked"<?php endif; ?>
        value="html" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#8}'; endif;echo translate_smarty(array('id' => 'ad_type_html'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#8}'; endif;?>
</li>
        
        <li><input type="radio" name="ad_type" <?php if ($this->_tpl_vars['ad']->type == 'reference'): ?>checked="checked"<?php endif; ?>
        value="reference" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#9}'; endif;echo translate_smarty(array('id' => 'ad_type_reference'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#9}'; endif;?>
</li>
        
        <li><input type="radio" name="ad_type" <?php if ($this->_tpl_vars['ad']->type == 'disabled'): ?>checked="checked"<?php endif; ?>
        value="disabled" class="ad_type_selector" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#10}'; endif;echo translate_smarty(array('id' => 'ad_type_disabled'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#10}'; endif;?>
</li>
    </ul>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#11}'; endif;echo translate_smarty(array('id' => 'ad_details_heading'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#11}'; endif;?>
</h2>
    <div class="ad_details" id="add_eventdefault">
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#12}'; endif;echo translate_smarty(array('id' => 'ad_eventdefault_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#12}'; endif;?>
</p>
    </div>
    
    <div class="ad_details" id="add_default">
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#13}'; endif;echo translate_smarty(array('id' => 'ad_default_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#13}'; endif;?>
</p>
    </div>
    
    <div class="ad_details" id="add_disabled">
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#14}'; endif;echo translate_smarty(array('id' => 'ad_disabled_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#14}'; endif;?>
</p>
    </div>
    
    <div class="ad_details" id="add_html">
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#15}'; endif;echo translate_smarty(array('id' => 'ad_html_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#15}'; endif;?>
</p>
        <textarea name="html" cols="80" rows="10"><?php if ($this->_tpl_vars['ad']->type == 'html'): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ad']->longData)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?></textarea>
    
    </div>
    
    <div class="ad_details" id="add_imageandlink">
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#16}'; endif;echo translate_smarty(array('id' => 'ad_imageandlink_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#16}'; endif;?>
</p>
        <table class="narrow">
            <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#17}'; endif;echo translate_smarty(array('id' => 'ad_link'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#17}'; endif;?>
</td>
                <td colspan="2"><input name="url" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['ad']->url)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="50" type="text" /></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td rowspan="6"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#18}'; endif;echo translate_smarty(array('id' => 'ad_image'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#18}'; endif;?>
</td>
                <td rowspan="2">
                    <input type="radio" name="image_type" value="internal"
                            <?php if ($this->_tpl_vars['ad']->imageReference !== null): ?>checked="checked"<?php endif; ?>/></td>
                <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#19}'; endif;echo translate_smarty(array('id' => 'ad_select'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#19}'; endif;?>
</td>            
            </tr>
            <tr><td>
                <select  class="selectRadioOnChange" name="image_ref">
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['images'],'selected' => $this->_tpl_vars['ad']->imageReference), $this);?>

                </select>
            </td></tr>
            <tr><td rowspan="2"><input type="radio" name="image_type" value="upload"/></td><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#20}'; endif;echo translate_smarty(array('id' => 'ad_upload'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#20}'; endif;?>
</td>
            </tr>
            <tr><td>
                <input name="image_file"  class="selectRadioOnChange" type="file" />
                </td></tr>
            <tr><td rowspan="2"><input type="radio" name="image_type" value="link"
                            <?php if ($this->_tpl_vars['ad']->imageReference === null): ?>checked="checked"<?php endif; ?>/></td><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#21}'; endif;echo translate_smarty(array('id' => 'ad_link'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#21}'; endif;?>
</td>
            </tr>
            <tr><td>
                <input name="image_url" class="selectRadioOnChange" <?php if ($this->_tpl_vars['ad']->type == 'imageandlink'): ?>value="<?php echo ((is_array($_tmp=$this->_tpl_vars['ad']->imageURL)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?> type="text" />
                </td></tr>
        </table>
    </div>
    
    <div class="ad_details" id="add_reference">
        <?php $this->assign('ref_sel', false); ?>
        <?php if ($this->_tpl_vars['ad']->type == 'reference'): ?>
            <?php $this->assign('ref_sel', $this->_tpl_vars['ad']->longData); ?>
        <?php endif; ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#22}'; endif;echo translate_smarty(array('id' => 'ad_reference_description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#22}'; endif;?>
</p>
        <table><tr><td>
        <ul class="nobullets">
            <?php $_from = $this->_tpl_vars['globalReferenceOptions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a']):
?>
            <?php ob_start(); ?>ad_location_<?php echo $this->_tpl_vars['a']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
            
                <li><input type="radio" name="ad_ref" value="<?php echo $this->_tpl_vars['a']; ?>
"
                           <?php if ($this->_tpl_vars['a'] == $this->_tpl_vars['ref_sel']): ?>checked="checked"<?php endif; ?>
                           /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#23}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['locid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#23}'; endif;?>
</li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
        </td>
        <?php if ($this->_tpl_vars['eventReferenceOptions']): ?>
            <td>
                <ul class="nobullets">
                <?php $_from = $this->_tpl_vars['eventReferenceOptions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['a']):
?>
                <?php ob_start(); ?>ad_event_location_<?php echo $this->_tpl_vars['a']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
                
                    <li><input type="radio" name="ad_ref" value="e-<?php echo $this->_tpl_vars['a']; ?>
"
                               <?php ob_start(); ?>e-<?php echo $this->_tpl_vars['a']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ea', ob_get_contents());ob_end_clean(); ?>
                               
                               <?php if ($this->_tpl_vars['ea'] == $this->_tpl_vars['ref_sel']): ?>checked="checked"<?php endif; ?>
                               /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#24}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['locid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#24}'; endif;?>
</li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
            </td>
        <?php endif; ?>
        
        </tr></table>
    </div>
    
    <hr />
    <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#25}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#25}'; endif;?>
" />
    <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#26}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#26}'; endif;?>
" name="preview" />
    <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e5c576800db88c9c04f36e695e2f0514#27}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e5c576800db88c9c04f36e695e2f0514#27}'; endif;?>
" name="cancel" />
    
    
    <script type="text/javascript">
    //<![CDATA[
    <?php echo '
    $(document).ready(function(){
        $(".ad_details").hide();
        $(".ad_type_selector").click(changeType);
        
        var newel = document.getElementById("add_'; ?>
<?php echo $this->_tpl_vars['ad']->type; ?>
<?php echo '");
        //alert("add_" +  this.name);
        selected = newel;
        $(newel).show();
        
        $(".selectRadioOnChange").change(selectPreviousRadio);
        $("input.selectRadioOnChange").keyup(selectPreviousRadioOnChange);
        //$(".selectRadioOnChange").keydown(selectPreviousRadio);
    });
    
    var lt = null;
    
    // Usage: When the value of an input is changed, the radio box before it gets selected
    function selectPreviousRadioOnChange() {        
        if (lt != null){
            if (this.value != lt) {
                lt = this.value;
                this.sp = selectPreviousRadio;
                this.sp();                
            }
        } else {
            lt = this.value;
        }
        
    }
    
    // Selects the radio button before the current input
    function selectPreviousRadio() {
        
        var prev =this.parentNode.parentNode.previousSibling;
        while (!prev.tagName) prev = prev.previousSibling;
        var input = $(prev).find("input").get(0)
        var name = input.name;
        //$("input[name=\'" + name + "\']").each(function(){this.checked = false;});
        input.checked = true;
    }
    
    var selected = null;
    
    // Closes the current ad panel and displays the one matching the new type selection
    function changeType() {
        if (!this.name) return;
        if (selected) $(selected).hide();
        
        var newel = document.getElementById("add_" + this.value);
        //alert("add_" +  this.name);
        selected = newel;
        $(newel).show();
        
    }
    
    '; ?>

    
    
    //]]>
    </script>
    </form>
</div>
<?php if ($_REQUEST['preview']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>