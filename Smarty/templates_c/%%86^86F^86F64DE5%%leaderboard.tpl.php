<?php /* Smarty version 2.6.26, created on 2010-02-16 14:51:14
         compiled from eventviews/leaderboard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/leaderboard.tpl', 77, false),array('function', 'math', 'eventviews/leaderboard.tpl', 85, false),array('function', 'counter', 'eventviews/leaderboard.tpl', 92, false),array('modifier', 'escape', 'eventviews/leaderboard.tpl', 88, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%86^86F^86F64DE5%%leaderboard.tpl.inc'] = '5c17b4d39f72ab32c6b57151c86e15b2'; ?> <?php if ($this->_tpl_vars['mode'] == 'head'): ?>
 
<style type="text/css"><?php echo '
    .resultrow td, .resultrow th {
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        text-align: center;
        
        margin: 0;
    }
    
    .results td, .results th {
        background-color: #EEE;
        text-align: center;
        border: 2px solid white;
    }
    
    .round_selection_table .selected {
        background-color: #DDD;
        
    }
    
    .results {
        border-collapse: collapse;
    }
    
    .rightside {
        text-align: right !important;
    }
    .leftside {
        text-align: left !important;
    }
    
    .thr {
        
    }
    .sdtd { background-color: white !important}
    
    .sd {
        background-color: #EEE !important;
        font-weight: bold;
        min-width: 16px;
        
        
    }
    
'; ?>
</style>
<?php else: ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>


<?php $this->assign('extrahead', $this->_tpl_vars['xtrahead']); ?>
<p class="preliminary" style="display: none">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#0}'; endif;echo translate_smarty(array('id' => 'preliminary_results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#0}'; endif;?>

</p>


<table class="results ">       
    
    <?php $_from = $this->_tpl_vars['resultsByClass']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class'] => $this->_tpl_vars['results']):
?>
    <tr style="border: none">
        <?php echo smarty_function_math(array('assign' => 'colspan','equation' => "5+x",'x' => $this->_tpl_vars['numRounds']), $this);?>

        <td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
" style="background-color: white" class="leftside">
            <a name="c<?php echo $this->_tpl_vars['class']; ?>
"></a>
            <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['class'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
        </td>
        
    </tr>
    <?php echo smarty_function_counter(array('assign' => 'rowind','start' => -1), $this);?>

    <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
    
        <?php echo smarty_function_counter(array('assign' => 'rowind'), $this);?>

        <?php if ($this->_tpl_vars['rowind'] % 10 == 0): ?>
        <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>

            <tr class="thr">
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#1}'; endif;echo translate_smarty(array('id' => 'result_pos'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#1}'; endif;?>
</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#2}'; endif;echo translate_smarty(array('id' => 'result_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#2}'; endif;?>
</th>                
                <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
                        <?php echo smarty_function_math(array('assign' => 'roundNumber','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

                        <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#3}'; endif;echo translate_smarty(array('id' => 'round_number_short','number' => $this->_tpl_vars['roundNumber']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#3}'; endif;?>
</th>
                        
                <?php endforeach; endif; unset($_from); ?>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#4}'; endif;echo translate_smarty(array('id' => 'leaderboard_hole'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#4}'; endif;?>
</th>
                <th>+/-</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#5}'; endif;echo translate_smarty(array('id' => 'result_cumulative'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#5}'; endif;?>
</th>
                <?php if ($this->_tpl_vars['includePoints']): ?>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#6}'; endif;echo translate_smarty(array('id' => 'result_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#6}'; endif;?>
</th>
                <?php endif; ?>
            </tr>
            <tr>
               <td style="height: 8px; background-color: white;"></td>
            </tr>
        <?php endif; ?>
        <tr class="resultrow">
            
            <td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_pos"><?php echo $this->_tpl_vars['result']['Standing']; ?>
</td>
            <td class="leftside"><?php echo ((is_array($_tmp=$this->_tpl_vars['result']['FirstName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['result']['LastName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
                <?php $this->assign('roundid', $this->_tpl_vars['round']->id); ?>
                <?php $this->assign('rresult', $this->_tpl_vars['result']['Results'][$this->_tpl_vars['roundid']]['Total']); ?>
                <?php if (! $this->_tpl_vars['rresult']): ?><?php $this->assign('rresult', 0); ?><?php endif; ?>                
                <td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_<?php echo $this->_tpl_vars['hr_id']; ?>
"><?php echo $this->_tpl_vars['rresult']; ?>
</td>
                
                
           
            <?php endforeach; endif; unset($_from); ?>
 
            <td  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_tc">
                <?php echo $this->_tpl_vars['result']['TotalCompleted']; ?>
</td>
            
            <td  id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_pm"><?php if ($this->_tpl_vars['result']['DidNotFinish']): ?>DNF<?php else: ?>
                <?php echo $this->_tpl_vars['result']['TotalPlusminus']; ?>
<?php endif; ?></td>
            <td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_t"><?php if ($this->_tpl_vars['result']['DidNotFinish']): ?>DNF<?php else: ?>
                <?php echo $this->_tpl_vars['result']['OverallResult']; ?>
<?php endif; ?></td>
            <?php if ($this->_tpl_vars['includePoints']): ?>
            <td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_tp">
                
                <?php $this->assign('tournamentPoints', $this->_tpl_vars['result']['TournamentPoints']); ?>
                <?php if (! $this->_tpl_vars['tournamentPoints']): ?><?php $this->assign('tournamentPoints', 0); ?><?php endif; ?>
                <?php echo smarty_function_math(array('equation' => "x/10",'x' => $this->_tpl_vars['tournamentPoints']), $this);?>

            </td>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['result']['Results'][$this->_tpl_vars['roundid']]['SuddenDeath']): ?>
            <td id="r<?php echo $this->_tpl_vars['result']['PlayerId']; ?>
_p" class="sdtd sd">                
                <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5c17b4d39f72ab32c6b57151c86e15b2#7}'; endif;echo translate_smarty(array('id' => 'result_sd_panel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5c17b4d39f72ab32c6b57151c86e15b2#7}'; endif;?>

           
            </td>
            <?php endif; ?>
            
        </tr>
        
    <?php endforeach; endif; unset($_from); ?>
    <?php endforeach; endif; unset($_from); ?>    
</table>
<?php endif; ?>