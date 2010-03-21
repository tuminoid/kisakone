<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:29
         compiled from ads.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'ads.tpl', 22, false),array('function', 'url', 'ads.tpl', 37, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%E5^E59^E5940378%%ads.tpl.inc'] = 'f8aadb8aa5f3405a29fcfc4f360b19eb'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'ads_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table class="oddrows">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#1}'; endif;echo translate_smarty(array('id' => 'ad_location'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#1}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#2}'; endif;echo translate_smarty(array('id' => 'ad_type'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#2}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#3}'; endif;echo translate_smarty(array('id' => 'ad_actions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#3}'; endif;?>
</th>
    </tr>
    <?php $_from = $this->_tpl_vars['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ad']):
?>
    <tr>
        <td><?php ob_start(); ?>ad_location_<?php echo $this->_tpl_vars['ad']->contentId; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('locid', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#4}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['locid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#4}'; endif;?>
</td>
        <td><?php ob_start(); ?>ad_type_<?php echo $this->_tpl_vars['ad']->type; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('typeid', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#5}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['typeid']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#5}'; endif;?>
</td>
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#6}'; endif;echo url_smarty(array('page' => 'editad','adType' => $this->_tpl_vars['ad']->contentId), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#6}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#7}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#7}'; endif;?>
</a>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#8}'; endif;echo url_smarty(array('page' => 'editad','adType' => $this->_tpl_vars['ad']->contentId,'preview' => 1), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#9}'; endif;echo translate_smarty(array('id' => 'preview'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f8aadb8aa5f3405a29fcfc4f360b19eb#9}'; endif;?>
</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>