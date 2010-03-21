<?php /* Smarty version 2.6.26, created on 2010-02-13 15:00:46
         compiled from tournament.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'tournament.tpl', 22, false),array('function', 'math', 'tournament.tpl', 56, false),array('function', 'url', 'tournament.tpl', 58, false),array('modifier', 'escape', 'tournament.tpl', 25, false),array('modifier', 'date_format', 'tournament.tpl', 71, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%41^418^41884409%%tournament.tpl.inc'] = '8fcfa1f6fe35d427f46cce27dcacd4f2'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#0}'; endif;echo translate_smarty(array('id' => 'tournament_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
<div><?php echo $this->_tpl_vars['tournament']->description; ?>
</div>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#1}'; endif;echo translate_smarty(array('id' => 'tournament_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#1}'; endif;?>
</h2>

<table class="narrow">
    <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#2}'; endif;echo translate_smarty(array('id' => 'tournament_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#2}'; endif;?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['tournament']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td></tr>
        <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#3}'; endif;echo translate_smarty(array('id' => 'tournament_year'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#3}'; endif;?>
</td><td><?php echo $this->_tpl_vars['tournament']->year; ?>
</td></tr>
        <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#4}'; endif;echo translate_smarty(array('id' => 'tournament_participants'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#4}'; endif;?>
</td><td><?php echo $this->_tpl_vars['tournament']->GetNumParticipants(); ?>
</td></tr>
        <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#5}'; endif;echo translate_smarty(array('id' => 'tournament_events_held'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#5}'; endif;?>
</td><td>
        <?php echo $this->_tpl_vars['tournament']->GetEventsHeld(); ?>
 / <?php echo $this->_tpl_vars['tournament']->GetNumEvents(); ?>

            
        </td></tr>
        <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#6}'; endif;echo translate_smarty(array('id' => 'tournament_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#6}'; endif;?>
</td><td>
            <?php $this->assign('level', $this->_tpl_vars['tournament']->GetLevel()); ?>
            <?php echo $this->_tpl_vars['level']->name; ?>

        </td>
        </tr>
        <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#7}'; endif;echo translate_smarty(array('id' => 'tournament_scorecalculation'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#7}'; endif;?>
</td>
        <td>
            <?php $this->assign('scm', $this->_tpl_vars['tournament']->GetScoreCalculation()); ?>
            <?php echo $this->_tpl_vars['scm']->name; ?>

            </td></tr>
        
    
</table>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#8}'; endif;echo translate_smarty(array('id' => 'tournament_events'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#8}'; endif;?>
</h2>
<table>
    <?php $_from = $this->_tpl_vars['tournament']->GetEvents(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['event']):
?>
            <tr>
                <td>#<?php echo smarty_function_math(array('equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>
</td>
            <?php if ($this->_tpl_vars['event']->isActive): ?>
            <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#9}'; endif;echo url_smarty(array('page' => 'event','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#9}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a> </td>
            <?php else: ?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <?php endif; ?>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->venue)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo $this->_tpl_vars['event']->fulldate; ?>
</td>
            <td>
            <?php if ($this->_tpl_vars['event']->signupState == 'signedup'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#10}'; endif;echo translate_smarty(array('id' => 'fee_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#10}'; endif;?>
 <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#11}'; endif;echo url_smarty(array('page' => 'payfees','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#11}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#12}'; endif;echo translate_smarty(array('id' => 'fee_payment_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#12}'; endif;?>
</a><?php endif; ?>
            <?php if ($this->_tpl_vars['event']->signupState == 'accepted'): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#13}'; endif;echo translate_smarty(array('id' => 'fee_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#13}'; endif;?>
<?php endif; ?>
            </td>
            <td>
                <?php if ($this->_tpl_vars['loggedon']): ?>
                    <?php if ($this->_tpl_vars['event']->management == '' && $this->_tpl_vars['event']->signupState == 'available'): ?><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#14}'; endif;echo url_smarty(array('page' => 'signup','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#15}'; endif;echo translate_smarty(array('id' => 'event_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#15}'; endif;?>
</a>
                        <span class="note"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#16}'; endif;echo translate_smarty(array('id' => 'signup_by_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#16}'; endif;?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['event']->signupend)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %h:%i%s") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %h:%i%s")); ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#17}'; endif;echo translate_smarty(array('id' => 'signup_by_end'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#17}'; endif;?>
</span>
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['event']->signupState == 'signedup'): ?><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#18}'; endif;echo url_smarty(array('page' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#18}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#19}'; endif;echo translate_smarty(array('id' => 'event_cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#19}'; endif;?>
</a><?php endif; ?>
                    <?php if ($this->_tpl_vars['event']->signupState == 'accepted'): ?><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#20}'; endif;echo url_smarty(array('page' => 'cancelsignup','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#20}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#21}'; endif;echo translate_smarty(array('id' => 'event_cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#21}'; endif;?>
</a><?php endif; ?>
                   
                    <?php if ($this->_tpl_vars['event']->management == 'td' || $this->_tpl_vars['event']->management == 'admin'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#22}'; endif;echo url_smarty(array('page' => 'manageevent','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#22}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#23}'; endif;echo translate_smarty(array('id' => 'event_manage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#23}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['event']->management != '' && $this->_tpl_vars['event']->isOngoing): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#24}'; endif;echo url_smarty(array('page' => 'enterresults','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#24}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#25}'; endif;echo translate_smarty(array('id' => 'event_enter_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#25}'; endif;?>
</a>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['event']->management == 'official'): ?>
                        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#26}'; endif;echo url_smarty(array('page' => 'addnews','id' => $this->_tpl_vars['event']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#26}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#27}'; endif;echo translate_smarty(array('id' => 'event_add_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#27}'; endif;?>
</a>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
            <?php endforeach; endif; unset($_from); ?>
</table>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#28}'; endif;echo translate_smarty(array('id' => 'tournament_participants'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#28}'; endif;?>
</h2>
<?php if ($this->_tpl_vars['edit']): ?>
<form method="POST">
    <input type="hidden" name="formid" value="tournament_tie_breakers" />
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#29}'; endif;echo translate_smarty(array('id' => 'edit_tournament_tie_breakers_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#29}'; endif;?>
</p>
<?php endif; ?>

<table>
<?php $_from = $this->_tpl_vars['tournament']->GetResultsByClass(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['classname'] => $this->_tpl_vars['participants']):
?>
<tr><td colspan="5"><h3><?php echo ((is_array($_tmp=$this->_tpl_vars['classname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3></td></tr>

    <tr>
        <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#30}'; endif;echo translate_smarty(array('id' => 'tournament_pos'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#30}'; endif;?>
</th>
        <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#31}'; endif;echo translate_smarty(array('id' => 'tournament_part_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#31}'; endif;?>
</th>
        <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#32}'; endif;echo translate_smarty(array('id' => 'pdga'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#32}'; endif;?>
</th>
        
        
        
        <th colspan="<?php echo $this->_tpl_vars['tournament']->GetNumEvents(); ?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#33}'; endif;echo translate_smarty(array('id' => 'tournament_event_positions'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#33}'; endif;?>
</th>
        
        <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#34}'; endif;echo translate_smarty(array('id' => 'tournament_overall'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#34}'; endif;?>
</th>
        <?php if ($this->_tpl_vars['edit']): ?>
        <th rowspan="2"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#35}'; endif;echo translate_smarty(array('id' => 'tie_breaker'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#35}'; endif;?>
</th>
        <?php endif; ?>
    </tr>
    <tr>
        <?php $_from = $this->_tpl_vars['tournament']->GetEvents(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['ignored']):
?>
            <?php echo smarty_function_math(array('assign' => 'num','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

            <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#36}'; endif;echo translate_smarty(array('id' => 'tournament_event_score','event' => $this->_tpl_vars['num']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#36}'; endif;?>
</th>        
        <?php endforeach; endif; unset($_from); ?>
    
    </tr>
    
    <?php $_from = $this->_tpl_vars['participants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['part']):
?>
    <tr>
        <td><?php echo $this->_tpl_vars['part']['Standing']; ?>
</td>
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#37}'; endif;echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['part']['Username']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#37}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['part']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['part']['LastName']; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['part']['PDGANumber']; ?>
</td>
        <?php $_from = $this->_tpl_vars['tournament']->GetEvents(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['event']):
?>
            <?php $this->assign('eventid', $this->_tpl_vars['event']->id); ?>        
            <?php $this->assign('result', $this->_tpl_vars['part']['Results'][$this->_tpl_vars['eventid']]); ?>
            <?php $this->assign('score', $this->_tpl_vars['result']['Score']); ?>
            <?php if (! $this->_tpl_vars['score']): ?><td>-</td>
            <?php else: ?><td><?php echo smarty_function_math(array('equation' => "x / 10",'x' => $this->_tpl_vars['score']), $this);?>
</td>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        
        <?php if (is_numeric ( $this->_tpl_vars['part']['OverallScore'] )): ?>
        <td><?php echo smarty_function_math(array('equation' => "x/10",'x' => $this->_tpl_vars['part']['OverallScore']), $this);?>
</td>
            <?php else: ?><td></td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['edit']): ?>
            <td><input type="text" value="<?php echo $this->_tpl_vars['part']['TieBreaker']; ?>
" name="tb_<?php echo $this->_tpl_vars['part']['PlayerId']; ?>
" /></td>
        <?php endif; ?>
        
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    

<?php endforeach; endif; unset($_from); ?>
</table>

<?php if ($this->_tpl_vars['edit']): ?>
<input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#38}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#38}'; endif;?>
" />
</form>
<?php elseif ($this->_tpl_vars['admin']): ?>
<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#39}'; endif;echo url_smarty(array('page' => 'tournament','id' => $_GET['id'],'edit' => 1), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#39}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#40}'; endif;echo translate_smarty(array('id' => 'edit_tournament_tie_breakers'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:8fcfa1f6fe35d427f46cce27dcacd4f2#40}'; endif;?>
</a></p>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>