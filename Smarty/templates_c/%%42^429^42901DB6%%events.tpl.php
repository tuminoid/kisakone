<?php /* Smarty version 2.6.26, created on 2010-02-15 16:04:11
         compiled from events.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sortheading', 'events.tpl', 32, false),array('function', 'url', 'events.tpl', 42, false),array('function', 'translate', 'events.tpl', 52, false),array('modifier', 'escape', 'events.tpl', 42, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%42^429^42901DB6%%events.tpl.inc'] = 'ecbf2dda6234a6618c437dc105b12ab5'; ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo $this->_tpl_vars['title']; ?>
</h2>

<?php if ($this->_tpl_vars['error']): ?>
    <p class="error"><?php echo $this->_tpl_vars['error']; ?>
</p>

<?php else: ?>
<table>
    <tr>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#0}'; endif;echo sortheading_smarty(array('field' => 'Name','id' => 'event_name','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#0}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#1}'; endif;echo sortheading_smarty(array('field' => 'VenueName','id' => 'event_location','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#1}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#2}'; endif;echo sortheading_smarty(array('field' => 'LevelName','id' => 'event_level','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#2}'; endif;?>
</th>
        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#3}'; endif;echo sortheading_smarty(array('field' => 'Date','id' => 'event_date','sortType' => 'date'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#3}'; endif;?>
</th>
        <th></th>
        <th></th>        
    </tr>
   <?php $_from = $this->_tpl_vars['events']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['event']):
?>
        <tr>
            <?php if ($this->_tpl_vars['event']->isAccessible()): ?>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#4}'; endif;echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#4}'; endif;?>
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
            <td><input type="hidden" value="<?php echo $this->_tpl_vars['event']->date; ?>
" />
            <?php echo $this->_tpl_vars['event']->fulldate; ?>
</td>
            <td class="event_links">
            <?php if ($this->_tpl_vars['event']->resultsLocked): ?>
                <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#5}'; endif;echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#5}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#6}'; endif;echo translate_smarty(array('id' => 'event_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#6}'; endif;?>
</a>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#7}'; endif;echo url_smarty(array('page' => 'event','view' => 'leaderboard','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#7}'; endif;?>
"><img src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/trophyIcon.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#8}'; endif;echo translate_smarty(array('id' => 'results_available'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#8}'; endif;?>
" /></a>
                
                <?php if ($this->_tpl_vars['event']->standing != null): ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#9}'; endif;echo translate_smarty(array('id' => 'your_standing','standing' => $this->_tpl_vars['event']->standing), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#9}'; endif;?>

                <?php endif; ?>
            <?php elseif ($this->_tpl_vars['event']->approved !== null): ?>
                                <?php if ($this->_tpl_vars['event']->approved || $this->_tpl_vars['event']->eventFeePaid): ?>
                    <?php if ($this->_tpl_vars['event']->signupState == 'accepted'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#10}'; endif;echo translate_smarty(array('id' => 'fee_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#10}'; endif;?>
<?php endif; ?>
                <?php else: ?>
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#11}'; endif;echo translate_smarty(array('id' => 'fee_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#11}'; endif;?>
 <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#12}'; endif;echo url_smarty(array('page' => 'event','view' => 'payment','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#12}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#13}'; endif;echo translate_smarty(array('id' => 'fee_payment_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#13}'; endif;?>
</a>
                <?php endif; ?>
     
            <?php endif; ?>
            
      
                <?php if ($this->_tpl_vars['loggedon']): ?>
                    <?php if ($this->_tpl_vars['event']->SignupPossible()): ?>
                        <?php if ($this->_tpl_vars['event']->approved !== null): ?>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#14}'; endif;echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#15}'; endif;echo translate_smarty(array('id' => 'event_cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#15}'; endif;?>
</a>
                        <?php elseif ($this->_tpl_vars['user']->role != 'admin' && $this->_tpl_vars['user']->role != 'manager' && $this->_tpl_vars['event']->management != 'td'): ?>
                        
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#16}'; endif;echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#16}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#17}'; endif;echo translate_smarty(array('id' => 'event_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#17}'; endif;?>
</a>
                            <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#18}'; endif;echo url_smarty(array('page' => 'event','view' => 'signupinfo','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#18}'; endif;?>
"><img src="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/goIcon.png" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#19}'; endif;echo translate_smarty(array('id' => 'sign_up_here'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#19}'; endif;?>
" /></a>
                            
                        <?php endif; ?>
                    <?php endif; ?>
                    
                                       
                    <?php if ($this->_tpl_vars['event']->management == 'td' || $this->_tpl_vars['user']->role == 'admin'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#20}'; endif;echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#20}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#21}'; endif;echo translate_smarty(array('id' => 'event_manage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#21}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if (( $this->_tpl_vars['event']->management != '' || $this->_tpl_vars['user']->role == 'admin' ) && $this->_tpl_vars['event']->EventOngoing()): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#22}'; endif;echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#22}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#23}'; endif;echo translate_smarty(array('id' => 'event_enter_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#23}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['event']->management == 'official'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#24}'; endif;echo url_smarty(array('page' => 'editnews','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#24}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#25}'; endif;echo translate_smarty(array('id' => 'event_add_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#25}'; endif;?>
</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4">
            <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#26}'; endif;echo translate_smarty(array('id' => 'no_matching_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#26}'; endif;?>
</p>
        </td></tr>
    <?php endif; unset($_from); ?>
</table>

<?php if ($_GET['id'] == '' || $_GET['id'] == 'default'): ?>
    <p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#27}'; endif;echo url_smarty(array('page' => 'events','id' => 'currentYear'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#27}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:ecbf2dda6234a6618c437dc105b12ab5#28}'; endif;echo translate_smarty(array('id' => 'all_current_year_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:ecbf2dda6234a6618c437dc105b12ab5#28}'; endif;?>
</a></p>
<?php endif; ?>

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