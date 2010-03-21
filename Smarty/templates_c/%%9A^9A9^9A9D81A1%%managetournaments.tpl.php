<?php /* Smarty version 2.6.26, created on 2010-02-17 09:35:25
         compiled from managetournaments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managetournaments.tpl', 22, false),array('function', 'url', 'managetournaments.tpl', 25, false),array('modifier', 'escape', 'managetournaments.tpl', 38, false),array('modifier', 'date_format', 'managetournaments.tpl', 55, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%9A^9A9^9A9D81A1%%managetournaments.tpl.inc'] = '5264e412fc4bd4e34df54736696626cc'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'managetournaments_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('title' => $this->_tpl_vars['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#1}'; endif;echo url_smarty(array('page' => 'edittournament','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#1}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#2}'; endif;echo translate_smarty(array('id' => 'new_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#2}'; endif;?>
</a></p>

<table class="oddrows narrow">
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#3}'; endif;echo translate_smarty(array('id' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#3}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#4}'; endif;echo translate_smarty(array('id' => 'year'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#4}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#5}'; endif;echo translate_smarty(array('id' => 'scorecalculation'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#5}'; endif;?>
</th>
        
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#6}'; endif;echo translate_smarty(array('id' => 'available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#6}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#7}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#7}'; endif;?>
</th>
    </tr>
<?php $_from = $this->_tpl_vars['tournaments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tournament']):
?>
    <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo $this->_tpl_vars['tournament']->year; ?>
</td>        
        <td><?php $this->assign('method', $this->_tpl_vars['tournament']->GetScoreCalculation()); ?>
            
            <?php echo $this->_tpl_vars['method']->name; ?>
</td>
       
        <td>
            <?php if ($this->_tpl_vars['tournament']->available): ?>
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#8}'; endif;echo translate_smarty(array('id' => "yes!"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#8}'; endif;?>

            <?php else: ?>
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#9}'; endif;echo translate_smarty(array('id' => 'not'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#9}'; endif;?>

            <?php endif; ?>
        </td>
        <td>
            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#10}'; endif;echo url_smarty(array('page' => 'edittournament','id' => $this->_tpl_vars['tournament']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#10}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#11}'; endif;echo translate_smarty(array('id' => 'edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#11}'; endif;?>
</a>
        </td>
        
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %h:%i%s") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %h:%i%s")); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['summary'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#12}'; endif;echo url_smarty(array('page' => 'edittournament','id' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#12}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5264e412fc4bd4e34df54736696626cc#13}'; endif;echo translate_smarty(array('id' => 'new_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5264e412fc4bd4e34df54736696626cc#13}'; endif;?>
</a></p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 