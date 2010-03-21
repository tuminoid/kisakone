<?php /* Smarty version 2.6.26, created on 2010-02-16 14:45:53
         compiled from eventviews/schedule.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'eventviews/schedule.tpl', 37, false),array('function', 'translate', 'eventviews/schedule.tpl', 38, false),array('function', 'url', 'eventviews/schedule.tpl', 68, false),array('modifier', 'date_format', 'eventviews/schedule.tpl', 39, false),array('modifier', 'escape', 'eventviews/schedule.tpl', 60, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C5^C53^C5385C2C%%schedule.tpl.inc'] = 'b7a7064c589015121323320b1afb117b'; ?> <?php if ($this->_tpl_vars['mode'] != 'body'): ?>
 <style type="text/css"><?php echo '
.selected td {
    background-color: #DFD;
}
'; ?>
</style>
<?php else: ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>



<?php if (! $_GET['round']): ?>
    <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>    
        <?php echo smarty_function_math(array('assign' => 'num','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

        <h3><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#0}'; endif;echo translate_smarty(array('id' => 'round_title','number' => $this->_tpl_vars['num']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#0}'; endif;?>
</h3>
        <div><?php echo ((is_array($_tmp=$this->_tpl_vars['round']->starttime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</div>
        <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['round']->starttime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('start', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->_tpl_vars['round']->starttype == 'sequential'): ?>            
            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#1}'; endif;echo translate_smarty(array('id' => 'sequential_start','time' => $this->_tpl_vars['start']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#1}'; endif;?>
</p>
        <?php elseif ($this->_tpl_vars['round']->starttype == 'simultaneous'): ?>
            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#2}'; endif;echo translate_smarty(array('id' => 'simultaneous_start','time' => $this->_tpl_vars['start']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#2}'; endif;?>
</p>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['round']->groupsAvailable()): ?>
            <?php $this->assign('group', $this->_tpl_vars['round']->GetUserGroup()); ?>
            <?php if ($this->_tpl_vars['group']): ?>
                <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#3}'; endif;echo translate_smarty(array('id' => 'your_group'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#3}'; endif;?>
 <?php if ($this->_tpl_vars['round']->groupsFinished === null): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#4}'; endif;echo translate_smarty(array('id' => 'preliminary'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#4}'; endif;?>
<?php endif; ?></p>
                <p style="float: left; margin: 8px;">
                <?php if ($this->_tpl_vars['round']->starttype == 'simultaneous'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#5}'; endif;echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['0']['StartingHole']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#5}'; endif;?>

                  <?php else: ?>
                  <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['0']['StartingTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

                  <?php endif; ?></p>
                <table class="narrow">
                <?php $_from = $this->_tpl_vars['group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['player']):
?>
                    <tr>
          
                        <td>
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['player']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['player']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                        </td>
                        <td>
                            <?php echo $this->_tpl_vars['player']['ClassificationName']; ?>
    
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
                </table>
                <?php if ($this->_tpl_vars['allow_print']): ?><p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#6}'; endif;echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#6}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#7}'; endif;echo translate_smarty(array('id' => 'print_score_card'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#7}'; endif;?>
</a></p><?php endif; ?>
            <?php endif; ?>
            <p>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#8}'; endif;echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'schedule','round' => $this->_tpl_vars['num']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#9}'; endif;echo translate_smarty(array('id' => 'view_group_list'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#9}'; endif;?>
</a>
                <?php if ($this->_tpl_vars['round']->groupsFinished === null): ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#10}'; endif;echo translate_smarty(array('id' => 'groups_not_finished'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#10}'; endif;?>

                <?php endif; ?>
            </p>
        <?php endif; ?>
        <hr />
    <?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<?php echo smarty_function_math(array('assign' => 'num','equation' => "x-1",'x' => $_GET['round']), $this);?>

 <?php $this->assign('round', $this->_tpl_vars['rounds'][$this->_tpl_vars['num']]); ?>    
    <h3><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#11}'; endif;echo translate_smarty(array('id' => 'round_title','number' => $_GET['round']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#11}'; endif;?>
</h3>
    <?php if ($this->_tpl_vars['allow_print']): ?><p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#12}'; endif;echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#12}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#13}'; endif;echo translate_smarty(array('id' => 'print_score_card'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#13}'; endif;?>
</a></p><?php endif; ?>
    <table>
        <?php $this->assign('lastGroup', -1); ?>
        <?php $_from = $this->_tpl_vars['round']->GetAllGroups(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
            <?php if ($this->_tpl_vars['group']['PoolNumber'] != $this->_tpl_vars['lastGroup']): ?>
                <?php $this->assign('lastGroup', $this->_tpl_vars['group']['PoolNumber']); ?>
                <tr><td>&nbsp;</td></tr>
            <?php endif; ?>
            
            <?php if ($this->_tpl_vars['group']['UserId'] == $this->_tpl_vars['user']->id): ?>
            <tr class="selected">
            <?php else: ?>
            <tr>
                <?php endif; ?>
                <td><?php echo $this->_tpl_vars['group']['PoolNumber']; ?>
</td>
                <td>
                    <?php if ($this->_tpl_vars['round']->starttype == 'simultaneous'): ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#14}'; endif;echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['StartingHole']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#14}'; endif;?>

                    <?php else: ?>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['StartingTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                </td>
                <td>
                    <?php echo $this->_tpl_vars['group']['ClassificationName']; ?>
    
                </td>
            </tr>            
        <?php endforeach; endif; unset($_from); ?>
    </table>
    <?php if ($this->_tpl_vars['allow_print']): ?><p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#15}'; endif;echo url_smarty(array('page' => 'printscorecard','id' => $_GET['id'],'round' => $_GET['round']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#15}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:b7a7064c589015121323320b1afb117b#16}'; endif;echo translate_smarty(array('id' => 'print_score_card'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:b7a7064c589015121323320b1afb117b#16}'; endif;?>
</p><?php endif; ?>
<?php endif; ?>
<?php endif; ?>