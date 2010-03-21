<?php /* Smarty version 2.6.26, created on 2010-02-16 14:56:37
         compiled from managecourses.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managecourses.tpl', 22, false),array('function', 'url', 'managecourses.tpl', 26, false),array('modifier', 'escape', 'managecourses.tpl', 39, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%BC^BC0^BC0DD097%%managecourses.tpl.inc'] = 'a379db7967275fcdecd975e75e920eed'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'managecourses_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($_GET['id']): ?>
<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#1}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new','event' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#1}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#2}'; endif;echo translate_smarty(array('id' => 'new_course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#2}'; endif;?>
</a></p>
<?php else: ?>
<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#3}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#3}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#4}'; endif;echo translate_smarty(array('id' => 'new_course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#4}'; endif;?>
</a></p>
<?php endif; ?>

<table class="oddrows narrow">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#5}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#5}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#6}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#6}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#7}'; endif;echo translate_smarty(array('id' => 'copy'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#7}'; endif;?>
</th>
    </tr>
<?php $_from = $this->_tpl_vars['courses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['course']):
?>
    <tr>        
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
       
        <td>
            <?php if ($_GET['id'] && ! $this->_tpl_vars['admin']): ?>
                <?php if ($this->_tpl_vars['course']['Event'] == $_GET['id']): ?>
                 <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#8}'; endif;echo url_smarty(array('page' => 'editcourse','id' => $this->_tpl_vars['course']['id'],'event' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#9}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#9}'; endif;?>
</a>
                <?php else: ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#10}'; endif;echo translate_smarty(array('id' => 'edit_blocked'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#10}'; endif;?>

                <?php endif; ?>
            <?php else: ?>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#11}'; endif;echo url_smarty(array('page' => 'editcourse','id' => $this->_tpl_vars['course']['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#11}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#12}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#12}'; endif;?>
</a>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($_GET['id']): ?>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#13}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new','template' => $this->_tpl_vars['course']['id'],'event' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#13}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#14}'; endif;echo translate_smarty(array('id' => 'copy'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#14}'; endif;?>
</a>
            <?php else: ?>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#15}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new','template' => $this->_tpl_vars['course']['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#15}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#16}'; endif;echo translate_smarty(array('id' => 'copy'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#16}'; endif;?>
</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<?php if ($_GET['id']): ?>
<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#17}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new','event' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#17}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#18}'; endif;echo translate_smarty(array('id' => 'new_course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#18}'; endif;?>
</a></p>
<?php else: ?>
<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#19}'; endif;echo url_smarty(array('page' => 'editcourse','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#19}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:a379db7967275fcdecd975e75e920eed#20}'; endif;echo translate_smarty(array('id' => 'new_course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a379db7967275fcdecd975e75e920eed#20}'; endif;?>
</a></p>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 