<?php /* Smarty version 2.6.26, created on 2010-01-30 08:17:18
         compiled from support/eventEditForm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/eventEditForm.tpl', 5, false),array('function', 'formerror', 'support/eventEditForm.tpl', 33, false),array('function', 'html_options', 'support/eventEditForm.tpl', 46, false),array('modifier', 'escape', 'support/eventEditForm.tpl', 32, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%7F^7FB^7FB4B242%%eventEditForm.tpl.inc'] = '72e004ededd9da154fc969b244f961f5'; ?><?php if ($this->_tpl_vars['new']): ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#0}'; endif;echo translate_smarty(array('id' => 'newevent_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#0}'; endif;?>

<?php else: ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#1}'; endif;echo translate_smarty(array('id' => 'editevent_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#1}'; endif;?>

<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('autocomplete' => 1,'ui' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#2}'; endif;echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#2}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#3}'; endif;echo translate_smarty(array('id' => 'month_default','assign' => 'month_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#3}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#4}'; endif;echo translate_smarty(array('id' => 'day_default','assign' => 'day_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#4}'; endif;?>


<div class="nojs">
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#5}'; endif;echo translate_smarty(array('id' => 'page_requires_javascript'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#5}'; endif;?>

</div>

<form method="POST" class="evenform jsonly" id="eventform">
    <h2><?php if ($this->_tpl_vars['new']): ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#6}'; endif;echo translate_smarty(array('id' => 'newevent_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#6}'; endif;?>

        <input type="hidden" name="formid" value="new_event" />
    <?php else: ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#7}'; endif;echo translate_smarty(array('id' => 'editevent_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#7}'; endif;?>

        <input type="hidden" name="formid" value="edit_event" />
        <input type="hidden" name="eventid" value="<?php echo $this->_tpl_vars['event']['id']; ?>
" />
    <?php endif; ?></h2>
    
    
    <div>
        <label for="name"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#8}'; endif;echo translate_smarty(array('id' => 'event_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#8}'; endif;?>
</label>
        <input type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#9}'; endif;echo formerror_smarty(array('field' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#9}'; endif;?>

    </div>
    <div>
        
        <label for="venue"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#10}'; endif;echo translate_smarty(array('id' => 'event_venue'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#10}'; endif;?>
</label>
        <input type="text" name="venue" id="venueField" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['venue'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#11}'; endif;echo formerror_smarty(array('field' => 'venue'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#11}'; endif;?>

    </div>
    
    <div>
        <label for="tournament"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#12}'; endif;echo translate_smarty(array('id' => 'event_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#12}'; endif;?>
</label>
        <select name="tournament">
            <option value="" <?php if (! $this->_tpl_vars['event']['tournament']): ?>selected="true"<?php endif; ?>><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#13}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#13}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['tournament_options'],'selected' => $this->_tpl_vars['event']['tournament']), $this);?>

        </select>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#14}'; endif;echo formerror_smarty(array('field' => 'tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#14}'; endif;?>

    </div>
    
    <div>
        <label for="level"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#15}'; endif;echo translate_smarty(array('id' => 'event_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#15}'; endif;?>
</label>
        <select name="level">
            <option value="" selected="true"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#16}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#16}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['level_options'],'selected' => $this->_tpl_vars['event']['level']), $this);?>

        </select>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#17}'; endif;echo formerror_smarty(array('field' => 'level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#17}'; endif;?>

    </div>
    
    
    <div>
        <label for="start"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#18}'; endif;echo translate_smarty(array('id' => 'event_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#18}'; endif;?>
</label>

        <input type="text" name="start" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['start'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" id="start" class="useDatePicker" />
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#19}'; endif;echo formerror_smarty(array('field' => 'start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#19}'; endif;?>

    </div>
    
    <div>
        <label for="duration"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#20}'; endif;echo translate_smarty(array('id' => 'event_duration'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#20}'; endif;?>
</label>
        <input type="text" name="duration" style="min-width: 64px;"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['duration'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <span><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#21}'; endif;echo translate_smarty(array('id' => 'event_duration_days'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#21}'; endif;?>
</span>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#22}'; endif;echo formerror_smarty(array('field' => 'duration'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#22}'; endif;?>

    </div>
    
    <div>
        <label for="signup_start"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#23}'; endif;echo translate_smarty(array('id' => 'event_signup_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#23}'; endif;?>
</label>
        <input type="text" name="signup_start" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['signup_start'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="useDatePicker" />
        
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#24}'; endif;echo formerror_smarty(array('field' => 'signup_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#24}'; endif;?>

    </div>
    
    <div>
        <label for="signup_end"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#25}'; endif;echo translate_smarty(array('id' => 'event_signup_end'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#25}'; endif;?>
</label>
        <input type="text" name="signup_end" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['signup_end'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="useDatePicker" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#26}'; endif;echo formerror_smarty(array('field' => 'signup_end'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#26}'; endif;?>

    </div>
    
    <div>
        <label for="contact"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#27}'; endif;echo translate_smarty(array('id' => 'event_contact'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#27}'; endif;?>
</label>
        <input type="text" name="contact" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['contact'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#28}'; endif;echo formerror_smarty(array('field' => 'contact'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#28}'; endif;?>

    </div>
    
    <?php if ($this->_tpl_vars['new']): ?>
        <input type="hidden" name="activate" value="0" />
    <?php else: ?>
        <input type="checkbox" name="activate" <?php if ($this->_tpl_vars['event']['isactive']): ?> checked="1" <?php endif; ?>
        />
        <label class="checkboxlabel" for="activate">
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#29}'; endif;echo translate_smarty(array('id' => 'event_activate'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#29}'; endif;?>
</label>
    <?php endif; ?>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#30}'; endif;echo translate_smarty(array('id' => 'event_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#30}'; endif;?>
</h2>
    
    <div>
        <label for="classList"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#31}'; endif;echo translate_smarty(array('id' => 'event_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#31}'; endif;?>
</label>
        <select name="classList" id="classList">
            <option value="" selected="true"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#32}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#32}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_options']), $this);?>

        </select>
        <button href="#" id="addClass"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#33}'; endif;echo translate_smarty(array('id' => 'event_add_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#33}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#34}'; endif;echo formerror_smarty(array('field' => 'classList_'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#34}'; endif;?>

    </div>
    
    <ul class="editList" id="classListList">
        
    </ul>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#35}'; endif;echo formerror_smarty(array('field' => 'classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#35}'; endif;?>

    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#36}'; endif;echo translate_smarty(array('id' => 'event_rounds'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#36}'; endif;?>
</h2>
    <div>
        <label for="roundStart"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#37}'; endif;echo translate_smarty(array('id' => 'round_start_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#37}'; endif;?>
</label>
        <input name="roundStart" class="useDatePicker" type="text" id="roundStart" />
    
        <span><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#38}'; endif;echo translate_smarty(array('id' => 'event_round_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#38}'; endif;?>
</span>
        <input name="holes" style="min-width: 0" type="text" id="roundStartTime" />
    
        <span><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#39}'; endif;echo translate_smarty(array('id' => 'event_round_holes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#39}'; endif;?>
</span>
        <input name="holes" style="min-width: 0" type="text" id="holes" value="18" />
        <button href="#" id="addRound"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#40}'; endif;echo translate_smarty(array('id' => 'event_add_round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#40}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#41}'; endif;echo formerror_smarty(array('field' => 'round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#41}'; endif;?>

    </div>
    
    <ul class="editList" id="roundList">
        
    </ul>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#42}'; endif;echo formerror_smarty(array('field' => 'rounds'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#42}'; endif;?>

    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#43}'; endif;echo translate_smarty(array('id' => 'event_management'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#43}'; endif;?>
</h2>
    
    <div>
        <label for="td"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#44}'; endif;echo translate_smarty(array('id' => 'event_td'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#44}'; endif;?>
</label>
        <input type="text"
               <?php if (! $this->_tpl_vars['allowTdChange']): ?> disabled="true"<?php endif; ?>
               name="td" id="td" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['td'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#45}'; endif;echo formerror_smarty(array('field' => 'td'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#45}'; endif;?>

    </div>
    
    <div>
        <label for="official"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#46}'; endif;echo translate_smarty(array('id' => 'event_official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#46}'; endif;?>
</label>
        <input type="text" name="official" id="official" />
        <button href="#" id="addOfficial"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#47}'; endif;echo translate_smarty(array('id' => 'event_add_official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#47}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#48}'; endif;echo formerror_smarty(array('field' => 'official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#48}'; endif;?>

    </div>
    
    <ul class="editList" id="officialList">
        
    </ul>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#49}'; endif;echo formerror_smarty(array('field' => 'officials'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#49}'; endif;?>

    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#50}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#50}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#51}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#51}'; endif;?>
" name="cancel" />
        
    </div>
    
</form>


<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'eventform\', \'name\', NonEmptyField, null);
    CheckedFormField(\'eventform\', \'venue\', NonEmptyField, null);
    CheckedFormField(\'eventform\', \'level\', NonEmptyField, null);
    CheckedFormField(\'eventform\', \'start\', NonEmptyField, null, {delayed: true});
    CheckedFormField(\'eventform\', \'duration\', PositiveIntegerField, null);
    CheckedFormField(\'eventform\', \'td\', NonEmptyField, null);
    CheckedFormField(\'eventform\', \'td\', AjaxField, \'validuser\', {delayed: true});
    CheckedFormField(\'eventform\', \'official\', AlwaysEmptyField, null);
    CheckedFormField(\'eventform\', \'classList\', AlwaysEmptyField, null);
    CheckedFormField(\'eventform\', \'roundStart\', AlwaysEmptyField, null);   
    
    $("#cancelButton").click(CancelSubmit);
    
        
    var options, a;
    jQuery(function(){
    options = { serviceUrl: baseUrl + "autocomplete/venue" };
    a = $(\'#venueField\').autocomplete(options);
    
    
    $(\'#td\').autocomplete(
      { serviceUrl: baseUrl + "autocomplete/users"  
      } 
    );
    $(\'#official\').autocomplete(
      { serviceUrl: baseUrl + "autocomplete/users"  
      } 
    );
    $(".useDatePicker").datepicker({
                            dateFormat: \'yy-mm-dd\',
                            changeMonth: true,
                            '; ?>

                            dayNames: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#52}'; endif;echo translate_smarty(array('id' => 'DayNameArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#52}'; endif;?>
],
                            dayNamesShort: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#53}'; endif;echo translate_smarty(array('id' => 'DayNameShortArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#53}'; endif;?>
],
                            dayNamesMin: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#54}'; endif;echo translate_smarty(array('id' => 'DayNameMinArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#54}'; endif;?>
],
                            monthNames: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#55}'; endif;echo translate_smarty(array('id' => 'MonthNameArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#55}'; endif;?>
],
                            monthNamesShort: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#56}'; endif;echo translate_smarty(array('id' => 'MonthNameShortArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#56}'; endif;?>
],
                            <?php echo '
                            firstDay: 1,
                            });
    
    $(\'#addClass\').click(addClass);
    $(\'#addRound\').click(addRound);
    $(\'#addOfficial\').click(addOfficial);
    

});
    
});

function AlwaysEmptyField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	

        if (!fullTest) return true;	    
	
	if (getvalue(field) == "") return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#57}'; endif;echo translate_smarty(array('id' => 'FormError_ShouldBeEmpty','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#57}'; endif;?>
";
	<?php echo '
    }
    
}

var classes = new Array();

'; ?>

var class_already_in_use = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#58}'; endif;echo translate_smarty(array('id' => 'class_already_in_use'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#58}'; endif;?>
";
var confirm_class_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#59}'; endif;echo translate_smarty(array('id' => 'confirm_class_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#59}'; endif;?>
";
var remove_class_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#60}'; endif;echo translate_smarty(array('id' => 'remove_class_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#60}'; endif;?>
";

var confirm_round_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#61}'; endif;echo translate_smarty(array('id' => 'confirm_round_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#61}'; endif;?>
";
var invalid_round ="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#62}'; endif;echo translate_smarty(array('id' => 'invalid_round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#62}'; endif;?>
";
var remove_round_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#63}'; endif;echo translate_smarty(array('id' => 'remove_round_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#63}'; endif;?>
";
var holesText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#64}'; endif;echo translate_smarty(array('id' => 'holes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#64}'; endif;?>
";

var confirm_official_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#65}'; endif;echo translate_smarty(array('id' => 'confirm_official_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#65}'; endif;?>
";
var remove_official_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:72e004ededd9da154fc969b244f961f5#66}'; endif;echo translate_smarty(array('id' => 'remove_official_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:72e004ededd9da154fc969b244f961f5#66}'; endif;?>
";

<?php echo '
function addClass(event, id) {
    if (event) event.preventDefault();
    
    var select = document.getElementById(\'classList\');
    if (!id) id = select.value;
    if (classes[id]) {
        alert(class_already_in_use);
        return;
    }
    
    classes[id] = true;
    
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';
    hidden.name = \'classOperations_\' + getUniqueFieldId();
    hidden.value = \'add:\' + id;
    
    select.parentNode.appendChild(hidden);
    
    
    var label = document.createElement(\'label\');
    var text = document.createTextNode(GetSelectOptionText(select, id));
    label.appendChild(text);
    
    var link = document.createElement(\'button\');
   
    
    text = document.createTextNode(remove_class_text);
    link.appendChild(text);    
    
    var li = document.createElement(\'li\');
    
    li.id = "class" + id;
    
    li.appendChild(label);    
    li.appendChild(link);
    
    document.getElementById(\'classListList\').appendChild(li);
    
     $(link).click(function(e){ removeClass(id); e.preventDefault(); });
    
    select.value = \'\';
    
}

function removeClass(id) {
    if (!confirm(confirm_class_removal)) return;
    var select = document.getElementById(\'classList\');
    
    classes[id] = false;
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';
    hidden.name = \'classOperations_\' + getUniqueFieldId();
    hidden.value = \'remove:\' + id;
    
    select.parentNode.appendChild(hidden);
    
    var li = $("#class" + id).get(0);
    li.parentNode.removeChild(li);
}

var roundIndex = 0;

function addRound(event, startDate, startTime, holes, roundId) {
    if (!roundId) roundId = "*";
    if (event) event.preventDefault();
    
    var dateElement = document.getElementById(\'roundStart\');
    var timeElement = document.getElementById(\'roundStartTime\');
    var holeElement = document.getElementById(\'holes\');
    
    if (!startDate) startDate = dateElement.value;
    if (!startTime) startTime = timeElement.value;
    if (!holes) holes = parseInt(holeElement.value);
    
    if (startDate == "" || startTime == "" || holes == null) {
        
        alert(invalid_round);
        return;
    }
    
    
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';    
    hidden.name = \'roundOperations_\' + getUniqueFieldId();
    hidden.value = \'add:\' + roundIndex + ":" + roundId + ":" + holes + ":" + startDate + ":" + startTime;
    
    dateElement.parentNode.appendChild(hidden);
    
    
    var label = document.createElement(\'label\');
    var text = document.createTextNode(startDate + " " + startTime + " (" + holes + " " + holesText + ") ");
    label.appendChild(text);
    
    var link = document.createElement(\'button\');
   
    link.href = \'#\';
    text = document.createTextNode(remove_round_text);
    link.appendChild(text);    
    
    var li = document.createElement(\'li\');
    
    li.id = "round" + roundIndex;    
    
    li.appendChild(label);    
    li.appendChild(link);
    
    document.getElementById(\'roundList\').appendChild(li);
    var ri = roundIndex;
     $(link).click(function(e){ removeRound(ri); e.preventDefault(); });
    
    roundIndex++;
    dateElement.value = \'\';
    timeElement.value = \'\';
    
}

function removeRound(id) {
    if (!confirm(confirm_round_removal)) return;
    var select = document.getElementById(\'roundStart\');
    
    classes[id] = false;
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';
    hidden.name = \'roundOperations_\' + getUniqueFieldId();
    hidden.value = \'remove:\' + id;
    
    select.parentNode.appendChild(hidden);
    
    var li = $("#round" + id).get(0);
    li.parentNode.removeChild(li);
}

function addOfficial(event, text) {
    if (event) event.preventDefault();
    
    var select = document.getElementById(\'official\');
    if (!text) text = select.value;
    if (text == "") {        
        return;
    }
    
    
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';
    hidden.name = \'officialOperations_\' + getUniqueFieldId();
    hidden.value = \'add:\' + text;
    
    select.parentNode.appendChild(hidden);
        
    var label = document.createElement(\'label\');
    var text = document.createTextNode(text);
    label.appendChild(text);
    
    var link = document.createElement(\'button\');
   
    link.href = \'#\';
    text = document.createTextNode(remove_official_text);
    link.appendChild(text);    
    
    var li = document.createElement(\'li\');
    
    
    li.appendChild(label);    
    li.appendChild(link);
    
    document.getElementById(\'officialList\').appendChild(li);
    
     $(link).click(function(e){ removeOfficial(label); e.preventDefault(); });
    
    select.value = \'\';
    
}

function removeOfficial(label) {
    if (!confirm(confirm_official_removal)) return;
    var select = document.getElementById(\'official\');
    
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';
    hidden.name = \'officialOperations_\' + getUniqueFieldId();
    hidden.value = \'remove:\' + $(label).text();
    
    select.parentNode.appendChild(hidden);
    
    label.parentNode.parentNode.removeChild(label.parentNode);
}


var lastUniqueFieldId = 0;
function getUniqueFieldId() {
    lastUniqueFieldId++;
    return lastUniqueFieldId;
}

'; ?>



$(document).ready(function(){
            
                 
    <?php $_from = $this->_tpl_vars['event']['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class']):
?>
        addClass(null, <?php echo $this->_tpl_vars['class']; ?>
);
    <?php endforeach; endif; unset($_from); ?>
    
    <?php $_from = $this->_tpl_vars['event']['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['round']):
?>
        addRound(null, "<?php echo ((is_array($_tmp=$this->_tpl_vars['round']['datestring'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
", "<?php echo ((is_array($_tmp=$this->_tpl_vars['round']['time'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
", <?php echo ((is_array($_tmp=$this->_tpl_vars['round']['holes'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
, <?php echo $this->_tpl_vars['round']['roundid']; ?>
);
    <?php endforeach; endif; unset($_from); ?>
    
    <?php $_from = $this->_tpl_vars['event']['officials']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['official']):
?>
        addOfficial(null, "<?php echo ((is_array($_tmp=$this->_tpl_vars['official'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
");
    <?php endforeach; endif; unset($_from); ?>
});

//]]>
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>