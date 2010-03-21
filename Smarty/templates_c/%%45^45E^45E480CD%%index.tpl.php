<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:06
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'index.tpl', 57, false),array('function', 'url', 'index.tpl', 80, false),array('modifier', 'escape', 'index.tpl', 80, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%45^45E^45E480CD%%index.tpl.inc'] = 'f4ee3f63ffa29c740fd6732af3baa213'; ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo $this->_tpl_vars['content']; ?>


<?php if ($this->_tpl_vars['error']): ?>
    <p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>

<?php else: ?>
<table>
        
    <?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['listtype'] => $this->_tpl_vars['events']):
?>
    <tr><td colspan="5"><h2>
    <?php if ($this->_tpl_vars['listtype'] == 0): ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#0}'; endif;echo translate_smarty(array('id' => 'relevant_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#0}'; endif;?>

        <?php $this->assign('trclass', 'hot_event_row'); ?>
    <?php elseif ($this->_tpl_vars['listtype'] == 1): ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#1}'; endif;echo translate_smarty(array('id' => 'upcoming_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#1}'; endif;?>

        <?php $this->assign('trclass', 'event_row'); ?>
    <?php elseif ($this->_tpl_vars['listtype'] == 2): ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#2}'; endif;echo translate_smarty(array('id' => 'past_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#2}'; endif;?>

        <?php $this->assign('trclass', 'event_row'); ?>
    <?php endif; ?>
    </h2></td></tr>
    
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#3}'; endif;echo translate_smarty(array('id' => 'event_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#3}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#4}'; endif;echo translate_smarty(array('id' => 'event_location'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#4}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#5}'; endif;echo translate_smarty(array('id' => 'event_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#5}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#6}'; endif;echo translate_smarty(array('id' => 'event_date'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#6}'; endif;?>
</th>
        <th></th>
        <th></th>        
    </tr>
   <?php $_from = $this->_tpl_vars['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?>

        <tr class="<?php echo $this->_tpl_vars['trclass']; ?>
">
            <?php if ($this->_tpl_vars['event']->isAccessible()): ?>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#7}'; endif;echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#7}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> </td>
            <?php else: ?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <?php endif; ?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->venue)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->levelName)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo $this->_tpl_vars['event']->fulldate; ?>
</td>
            <td class="event_links"> 
            <?php if ($this->_tpl_vars['event']->resultsLocked): ?>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#8}'; endif;echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#9}'; endif;echo translate_smarty(array('id' => 'event_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#9}'; endif;?>
</a>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#10}'; endif;echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#10}'; endif;?>
"><img src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/trophyIcon.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#11}'; endif;echo translate_smarty(array('id' => 'results_available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#11}'; endif;?>
" /></a>
                
                <?php if ($this->_tpl_vars['event']->standing != null): ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#12}'; endif;echo translate_smarty(array('id' => 'your_standing','standing' => $this->_tpl_vars['event']->standing), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#12}'; endif;?>

                <?php endif; ?>
            <?php elseif ($this->_tpl_vars['event']->approved !== null): ?>
                                <?php if ($this->_tpl_vars['event']->approved || $this->_tpl_vars['event']->eventFeePaid): ?>
                    <?php if ($this->_tpl_vars['event']->signupState == 'accepted'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#13}'; endif;echo translate_smarty(array('id' => 'fee_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#13}'; endif;?>
<?php endif; ?>
                <?php else: ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#14}'; endif;echo translate_smarty(array('id' => 'fee_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#14}'; endif;?>
 <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#15}'; endif;echo url_smarty(array('page' => 'event','view' => 'payment','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#15}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#16}'; endif;echo translate_smarty(array('id' => 'fee_payment_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#16}'; endif;?>
</a>
                <?php endif; ?>
     
            <?php endif; ?>
            
      
                <?php if ($this->_tpl_vars['loggedon']): ?>
                    <?php if ($this->_tpl_vars['event']->SignupPossible()): ?>
                        <?php if ($this->_tpl_vars['event']->approved !== null): ?>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#17}'; endif;echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#17}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#18}'; endif;echo translate_smarty(array('id' => 'event_cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#18}'; endif;?>
</a>
                        <?php elseif ($this->_tpl_vars['user']->role != 'admin' && $this->_tpl_vars['user']->role != 'manager' && $this->_tpl_vars['event']->management != 'td'): ?>
                        
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#19}'; endif;echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#19}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#20}'; endif;echo translate_smarty(array('id' => 'event_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#20}'; endif;?>
</a>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#21}'; endif;echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#21}'; endif;?>
"><img src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/goIcon.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#22}'; endif;echo translate_smarty(array('id' => 'sign_up_here'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#22}'; endif;?>
" /></a>
                            
                        <?php endif; ?>
                    <?php endif; ?>
                    
                                       
                    <?php if ($this->_tpl_vars['event']->management == 'td' || $this->_tpl_vars['user']->role == 'admin'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#23}'; endif;echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#23}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#24}'; endif;echo translate_smarty(array('id' => 'event_manage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#24}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if (( $this->_tpl_vars['event']->management != '' || $this->_tpl_vars['user']->role == 'admin' ) && $this->_tpl_vars['event']->EventOngoing()): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#25}'; endif;echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#25}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#26}'; endif;echo translate_smarty(array('id' => 'event_enter_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#26}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['event']->management == 'official'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#27}'; endif;echo url_smarty(array('page' => 'editnews','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#27}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#28}'; endif;echo translate_smarty(array('id' => 'event_add_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#28}'; endif;?>
</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4">
            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#29}'; endif;echo translate_smarty(array('id' => 'no_matching_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#29}'; endif;?>
</p>
        </td></tr>
    <?php endif; unset($_from); ?>
    
    <tr><td colspan="5">
    <?php if ($this->_tpl_vars['listtype'] == 0): ?>
        <p>&nbsp;</p>
    <?php elseif ($this->_tpl_vars['listtype'] == 1): ?>
        <p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#30}'; endif;echo url_smarty(array('page' => 'events','id' => 'upcoming'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#30}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#31}'; endif;echo translate_smarty(array('id' => 'show_all'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#31}'; endif;?>
</a></p>
    <?php elseif ($this->_tpl_vars['listtype'] == 2): ?>
        <p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#32}'; endif;echo url_smarty(array('page' => 'eventarchive'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#32}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f4ee3f63ffa29c740fd6732af3baa213#33}'; endif;echo translate_smarty(array('id' => 'show_archive'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f4ee3f63ffa29c740fd6732af3baa213#33}'; endif;?>
</a></p>
    <?php endif; ?>
    </td></tr>
    
    <?php endforeach; endif; unset($_from); ?>
</table>



<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 