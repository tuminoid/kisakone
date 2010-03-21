<?php /* Smarty version 2.6.26, created on 2010-02-15 15:55:50
         compiled from managelevels.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managelevels.tpl', 22, false),array('function', 'url', 'managelevels.tpl', 25, false),array('modifier', 'escape', 'managelevels.tpl', 37, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%19^19E^19EBBE75%%managelevels.tpl.inc'] = '0047d5faa6cff2ff93323bffbb8b2a93'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'managelevels_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#1}'; endif;echo url_smarty(array('page' => 'editlevel','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#1}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#2}'; endif;echo translate_smarty(array('id' => 'new_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#2}'; endif;?>
</a></p>

<table class="oddrows narrow">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#3}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#3}'; endif;?>
</th>        
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#4}'; endif;echo translate_smarty(array('id' => 'scorecalculation'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#4}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#5}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#5}'; endif;?>
</th>

        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#6}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#6}'; endif;?>
</th>
    </tr>
<?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class']):
?>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['class']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo $this->_tpl_vars['class']->getScoreCalculationName(); ?>
</td>
        <td>
            <?php if ($this->_tpl_vars['class']->available): ?>
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#7}'; endif;echo translate_smarty(array('id' => 'yes_'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#7}'; endif;?>

            <?php else: ?>
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#8}'; endif;echo translate_smarty(array('id' => 'no_'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#8}'; endif;?>

            <?php endif; ?>
        </td>
        <td>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#9}'; endif;echo url_smarty(array('page' => 'editlevel','id' => $this->_tpl_vars['class']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#9}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#10}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#10}'; endif;?>
</a>
        </td>
        
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#11}'; endif;echo url_smarty(array('page' => 'editlevel','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#11}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:0047d5faa6cff2ff93323bffbb8b2a93#12}'; endif;echo translate_smarty(array('id' => 'new_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:0047d5faa6cff2ff93323bffbb8b2a93#12}'; endif;?>
</a></p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 