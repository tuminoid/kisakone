<?php /* Smarty version 2.6.26, created on 2010-02-16 14:56:46
         compiled from editcourse.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'editcourse.tpl', 45, false),array('function', 'initializeGetFormFields', 'editcourse.tpl', 50, false),array('modifier', 'escape', 'editcourse.tpl', 76, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6E^6E8^6E883B05%%editcourse.tpl.inc'] = '64bc7280be747d35b0eb7d7cb4d9c93d'; ?><?php ob_start(); ?>
<style type="text/css"><?php echo '
input[type="text"] { min-width: 200px; }
'; ?>
</style>

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
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'editcourse_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['holeChooser']): ?>
    <form method="get">
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#1}'; endif;echo initializeGetFormFields_Smarty(array(), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#1}'; endif;?>

        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#2}'; endif;echo translate_smarty(array('id' => 'num_holes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#2}'; endif;?>
 <input type="text" name="holes" value="18" /></p>
        <p><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#3}'; endif;echo translate_smarty(array('id' => 'proceed'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#3}'; endif;?>
" /></p>
    </form>
<?php else: ?>
<?php if ($this->_tpl_vars['error']): ?>
<p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>
<?php endif; ?>

<?php if ($this->_tpl_vars['warning']): ?>
<p class="error"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#4}'; endif;echo translate_smarty(array('id' => 'course_edit_warning'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#4}'; endif;?>
</p>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="formid" value="manage_courses" />
    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#5}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#5}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#6}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#6}'; endif;?>
" />
	<?php if (! $this->_tpl_vars['warning']): ?><input type="submit" style="margin-left: 200px" name="delete" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#7}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#7}'; endif;?>
" /><?php endif; ?>
    </div>
    
    <div class="round">
        <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#8}'; endif;echo translate_smarty(array('id' => 'course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#8}'; endif;?>
</h2>
        <table class="narrow">
            <tr>                
                <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#9}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#9}'; endif;?>
</td>
                <td><input type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></td>
            </tr>
            <tr>                
                <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#10}'; endif;echo translate_smarty(array('id' => 'map_url'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#10}'; endif;?>
</td>
                <td><input type="text" name="map" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Map'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></td>
            </tr>
            <tr>                
                <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#11}'; endif;echo translate_smarty(array('id' => 'link'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#11}'; endif;?>
</td>
                <td><input type="text" name="link" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#12}'; endif;echo translate_smarty(array('id' => 'description'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#12}'; endif;?>
</p>
                    <textarea cols="80" rows="25" name="description"><?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                </td>
            </tr>

            <tr>
                 <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#13}'; endif;echo translate_smarty(array('id' => 'holes_list'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#13}'; endif;?>
   </td>
                 <td>
                    <table class="narrow">
                        <tr>
                            <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#14}'; endif;echo translate_smarty(array('id' => 'hole_number'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#14}'; endif;?>
</td>
                            <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#15}'; endif;echo translate_smarty(array('id' => 'par'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#15}'; endif;?>
</td>
                            <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#16}'; endif;echo translate_smarty(array('id' => 'hole_length'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#16}'; endif;?>
</td>
                        </tr>                        
                        <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
                        <tr>
                            <td>
                                
                                <?php echo $this->_tpl_vars['hole']->holeNumber; ?>

                                                                
                            </td>
                            <td>
                                <input type="text" size="4" name="h_<?php echo $this->_tpl_vars['hole']->holeNumber; ?>
_<?php echo $this->_tpl_vars['hole']->id; ?>
_par" value="<?php echo $this->_tpl_vars['hole']->par; ?>
" />
                            </td>
                            <td>
                                <input type="text" size="4" name="h_<?php echo $this->_tpl_vars['hole']->holeNumber; ?>
_<?php echo $this->_tpl_vars['hole']->id; ?>
_len" value="<?php echo $this->_tpl_vars['hole']->length; ?>
" />
                            </td>
                        </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                    
                 </td>
            </tr>
        </table>
        
    </div>
    
    
    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#17}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#17}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#18}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#18}'; endif;?>
" />
	<?php if (! $this->_tpl_vars['warning']): ?><input type="submit" style="margin-left: 200px" name="delete" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:64bc7280be747d35b0eb7d7cb4d9c93d#19}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:64bc7280be747d35b0eb7d7cb4d9c93d#19}'; endif;?>
" /><?php endif; ?>
    </div>
</form>


<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 