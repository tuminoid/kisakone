<?php /* Smarty version 2.6.26, created on 2010-02-15 16:58:44
         compiled from tournaments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'tournaments.tpl', 22, false),array('function', 'sortheading', 'tournaments.tpl', 34, false),array('function', 'url', 'tournaments.tpl', 45, false),array('modifier', 'escape', 'tournaments.tpl', 45, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%6A^6AD^6AD6E323%%tournaments.tpl.inc'] = 'b2d8606373819dbae2ec36316ab17d99'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#0}'; endif;echo translate_smarty(array('id' => 'tournaments_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#1}'; endif;echo translate_smarty(array('id' => 'tournaments'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#1}'; endif;?>
 <?php echo $this->_tpl_vars['year']; ?>
</h2>

<?php if ($this->_tpl_vars['error']): ?>
    <p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>

<?php else: ?>

<table>
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#2}'; endif;echo sortheading_smarty(array('id' => 'tournament_name','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#2}'; endif;?>
</th>
        
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#3}'; endif;echo sortheading_smarty(array('id' => 'tournament_participants','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#3}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#4}'; endif;echo sortheading_smarty(array('id' => 'tournament_events_held','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#4}'; endif;?>
</th>
         
    </tr>
    
   <?php $_from = $this->_tpl_vars['tournaments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['t']):
?>
       
        <tr>
            
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b2d8606373819dbae2ec36316ab17d99#5}'; endif;echo url_smarty(array('page' => 'tournament','id' => $this->_tpl_vars['t']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b2d8606373819dbae2ec36316ab17d99#5}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['t']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> </td>
            
            <td><?php echo $this->_tpl_vars['t']->GetNumParticipants(); ?>
</td>
            <td><?php echo $this->_tpl_vars['t']->GetEventsHeld(); ?>
 / <?php echo $this->_tpl_vars['t']->GetNumEvents(); ?>
</td>
           
           
        </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    $($(".SortHeading").get(0)).click();    
});

'; ?>



//]]>
</script>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>