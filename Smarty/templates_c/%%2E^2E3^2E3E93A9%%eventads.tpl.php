<?php /* Smarty version 2.6.26, created on 2010-02-16 14:52:14
         compiled from eventads.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventads.tpl', 27, false),array('function', 'url', 'eventads.tpl', 37, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%2E^2E3^2E3E93A9%%eventads.tpl.inc'] = 'f2a3c975ef2c5e8af1b690c61d5c8e51'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table class="oddrows">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#0}'; endif;echo translate_smarty(array('id' => 'ad_location'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#0}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#1}'; endif;echo translate_smarty(array('id' => 'ad_type'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#1}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#2}'; endif;echo translate_smarty(array('id' => 'ad_actions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#2}'; endif;?>
</th>
    </tr>
    <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad']):
?>
    <tr>
        <td><?php ob_start(); ?>ad_event_location_<?php echo $this->_tpl_vars['ad']->contentId; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#3}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['locid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#3}'; endif;?>
</td>
        <td><?php ob_start(); ?>ad_type_<?php echo $this->_tpl_vars['ad']->type; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('typeid', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#4}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['typeid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#4}'; endif;?>
</td>
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#5}'; endif;echo url_smarty(array('page' => 'editad','id' => $this->_tpl_vars['event']->id,'adType' => $this->_tpl_vars['ad']->contentId), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#5}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#6}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#6}'; endif;?>
</a>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#7}'; endif;echo url_smarty(array('page' => 'editad','id' => $this->_tpl_vars['event']->id,'adType' => $this->_tpl_vars['ad']->contentId,'preview' => 1), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#7}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#8}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f2a3c975ef2c5e8af1b690c61d5c8e51#8}'; endif;?>
</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>