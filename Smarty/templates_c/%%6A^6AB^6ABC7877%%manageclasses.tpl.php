<?php /* Smarty version 2.6.26, created on 2010-02-16 14:40:09
         compiled from manageclasses.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageclasses.tpl', 22, false),array('function', 'url', 'manageclasses.tpl', 25, false),array('modifier', 'escape', 'manageclasses.tpl', 38, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6A^6AB^6ABC7877%%manageclasses.tpl.inc'] = '29dac2f0abfd6e5c1b4b4b59af35b4ba'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'manageclasses_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#1}'; endif;echo url_smarty(array('page' => 'editclass','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#1}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#2}'; endif;echo translate_smarty(array('id' => 'new_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#2}'; endif;?>
</a></p>

<table class="oddrows narrow">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#3}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#3}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#4}'; endif;echo translate_smarty(array('id' => 'minage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#4}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#5}'; endif;echo translate_smarty(array('id' => 'maxage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#5}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#6}'; endif;echo translate_smarty(array('id' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#6}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#7}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#7}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#8}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#8}'; endif;?>
</th>
    </tr>
<?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class']):
?>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['class']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo $this->_tpl_vars['class']->minAge; ?>

        <?php if (! $this->_tpl_vars['class']->minAge): ?>-<?php endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['class']->maxAge; ?>

        <?php if (! $this->_tpl_vars['class']->maxAge): ?>-<?php endif; ?></td>
        <td>
            <?php if ($this->_tpl_vars['class']->gender == M): ?>
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#9}'; endif;echo translate_smarty(array('id' => 'male'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#9}'; endif;?>

                <?php elseif ($this->_tpl_vars['class']->gender == F): ?>
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#10}'; endif;echo translate_smarty(array('id' => 'female'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#10}'; endif;?>

                <?php else: ?>
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#11}'; endif;echo translate_smarty(array('id' => 'any'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#11}'; endif;?>

                
            <?php endif; ?>
        </td>
        <td>
            <?php if ($this->_tpl_vars['class']->available): ?>
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#12}'; endif;echo translate_smarty(array('id' => "yes!"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#12}'; endif;?>

            <?php else: ?>
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#13}'; endif;echo translate_smarty(array('id' => 'not'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#13}'; endif;?>

            <?php endif; ?>
        </td>
        <td>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#14}'; endif;echo url_smarty(array('page' => 'editclass','id' => $this->_tpl_vars['class']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#15}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#15}'; endif;?>
</a>
        </td>
        
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#16}'; endif;echo url_smarty(array('page' => 'editclass','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#16}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#17}'; endif;echo translate_smarty(array('id' => 'new_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:29dac2f0abfd6e5c1b4b4b59af35b4ba#17}'; endif;?>
</a></p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 