<?php /* Smarty version 2.6.26, created on 2010-02-15 15:55:42
         compiled from support/eventeditform.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/eventeditform.tpl', 28, false),array('function', 'formerror', 'support/eventeditform.tpl', 57, false),array('function', 'html_options', 'support/eventeditform.tpl', 70, false),array('function', 'html_select_time', 'support/eventeditform.tpl', 157, false),array('modifier', 'escape', 'support/eventeditform.tpl', 56, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%9E^9EF^9EF30BEC%%eventeditform.tpl.inc'] = '497238055e4fe9b3d580268c4599e881'; ?> <?php ob_start(); ?>
 <style type="text/css"><?php echo '
.narrow_selects select { min-width: 0; }
'; ?>
</style>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('extrahead', ob_get_contents());ob_end_clean(); ?>
<?php if ($this->_tpl_vars['new']): ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#0}'; endif;echo translate_smarty(array('id' => 'newevent_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#0}'; endif;?>

<?php else: ?>
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#1}'; endif;echo translate_smarty(array('id' => 'editevent_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#1}'; endif;?>

<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('autocomplete' => 1,'ui' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#2}'; endif;echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#2}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#3}'; endif;echo translate_smarty(array('id' => 'month_default','assign' => 'month_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#3}'; endif;?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#4}'; endif;echo translate_smarty(array('id' => 'day_default','assign' => 'day_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#4}'; endif;?>



<div class="nojs">
<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#5}'; endif;echo translate_smarty(array('id' => 'page_requires_javascript'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#5}'; endif;?>

</div>

<form method="post" class="evenform jsonly" id="eventform">
    <h2><?php if ($this->_tpl_vars['new']): ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#6}'; endif;echo translate_smarty(array('id' => 'newevent_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#6}'; endif;?>

        <input type="hidden" name="formid" value="new_event" />
    <?php else: ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#7}'; endif;echo translate_smarty(array('id' => 'editevent_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#7}'; endif;?>

        <input type="hidden" name="formid" value="edit_event" />
        <input type="hidden" name="eventid" value="<?php echo $this->_tpl_vars['event']['id']; ?>
" />
    <?php endif; ?></h2>
    
    
    <div>
        <label for="name"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#8}'; endif;echo translate_smarty(array('id' => 'event_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#8}'; endif;?>
</label>
        <input id="name" type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#9}'; endif;echo formerror_smarty(array('field' => 'name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#9}'; endif;?>

    </div>
    <div>
        
        <label for="venueField"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#10}'; endif;echo translate_smarty(array('id' => 'event_venue'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#10}'; endif;?>
</label>
        <input type="text" name="venue" id="venueField" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['venue'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#11}'; endif;echo formerror_smarty(array('field' => 'venue'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#11}'; endif;?>

    </div>
    
    <div>
        <label for="tournament"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#12}'; endif;echo translate_smarty(array('id' => 'event_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#12}'; endif;?>
</label>
        <select id="tournament" name="tournament">
            <option value="" <?php if (! $this->_tpl_vars['event']['tournament']): ?>selected="true"<?php endif; ?>><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#13}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#13}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['tournament_options'],'selected' => $this->_tpl_vars['event']['tournament']), $this);?>

        </select>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#14}'; endif;echo formerror_smarty(array('field' => 'tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#14}'; endif;?>

    </div>
    
    <div>
        <label for="level"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#15}'; endif;echo translate_smarty(array('id' => 'event_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#15}'; endif;?>
</label>
        <select id="level" name="level">
            <option value="" selected="true"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#16}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#16}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['level_options'],'selected' => $this->_tpl_vars['event']['level']), $this);?>

        </select>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#17}'; endif;echo formerror_smarty(array('field' => 'level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#17}'; endif;?>

    </div>
    
    
    <div>
        <label for="start"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#18}'; endif;echo translate_smarty(array('id' => 'event_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#18}'; endif;?>
</label>

        <input type="text" name="start" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['start'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" id="start" class="useDatePicker" />
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#19}'; endif;echo formerror_smarty(array('field' => 'start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#19}'; endif;?>

    </div>
    
    <div>
        <label for="duration"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#20}'; endif;echo translate_smarty(array('id' => 'event_duration'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#20}'; endif;?>
</label>
        <input id="duration" type="text" name="duration" style="min-width: 64px;"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['duration'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <span><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#21}'; endif;echo translate_smarty(array('id' => 'event_duration_days'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#21}'; endif;?>
</span>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#22}'; endif;echo formerror_smarty(array('field' => 'duration'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#22}'; endif;?>

    </div>
    
    <div>
        <label for="signup_start"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#23}'; endif;echo translate_smarty(array('id' => 'event_signup_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#23}'; endif;?>
</label>
        <input id="signup_start" type="text" name="signup_start" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['signup_start'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="useDatePicker" />
        
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#24}'; endif;echo formerror_smarty(array('field' => 'signup_start'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#24}'; endif;?>

    </div>
    
    <div>
        <label for="signup_end"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#25}'; endif;echo translate_smarty(array('id' => 'event_signup_end'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#25}'; endif;?>
</label>
        <input id="signup_end" type="text" name="signup_end" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['signup_end'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="useDatePicker" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#26}'; endif;echo formerror_smarty(array('field' => 'signup_end'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#26}'; endif;?>

    </div>
    
    <div>
        <label for="contact"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#27}'; endif;echo translate_smarty(array('id' => 'event_contact'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#27}'; endif;?>
</label>
        <input id="contact" type="text" name="contact" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['contact'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#28}'; endif;echo formerror_smarty(array('field' => 'contact'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#28}'; endif;?>

    </div>
    
    <div>
        <input id="requireFees_member" type="checkbox" name="requireFees_member" <?php if ($this->_tpl_vars['event']['requireFees_member']): ?> checked="checked" <?php endif; ?>/>
        <label class="checkboxlabel" for="requireFees_member"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#29}'; endif;echo translate_smarty(array('id' => 'event_require_member_fee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#29}'; endif;?>
</label>
        
        <br />
        <input id="requireFees_license" type="checkbox" name="requireFees_license" <?php if ($this->_tpl_vars['event']['requireFees_license']): ?> checked="checked" <?php endif; ?>/>
        <label class="checkboxlabel" for="requireFees_license"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#30}'; endif;echo translate_smarty(array('id' => 'event_require_license_fee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#30}'; endif;?>
</label>

    </div>
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#31}'; endif;echo translate_smarty(array('id' => 'event_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#31}'; endif;?>
</h2>
    
    <div>
        <label for="classList"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#32}'; endif;echo translate_smarty(array('id' => 'event_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#32}'; endif;?>
</label>
        <select name="classList" id="classList">
            <option value="" selected="true"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#33}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#33}'; endif;?>
</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['class_options']), $this);?>

        </select>
        <button href="#" id="addClass"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#34}'; endif;echo translate_smarty(array('id' => 'event_add_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#34}'; endif;?>
</button>
        <button href="#" id="addAllClasses"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#35}'; endif;echo translate_smarty(array('id' => 'event_add_all_classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#35}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#36}'; endif;echo formerror_smarty(array('field' => 'classList_'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#36}'; endif;?>

    </div>
    
    <ul class="editList" id="classListList">
        
    </ul>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#37}'; endif;echo formerror_smarty(array('field' => 'classes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#37}'; endif;?>

    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#38}'; endif;echo translate_smarty(array('id' => 'event_rounds'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#38}'; endif;?>
</h2>
    <div class="narrow_selects">
        <label for="roundStart"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#39}'; endif;echo translate_smarty(array('id' => 'round_start_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#39}'; endif;?>
</label>
        
        <select name="roundStart" id="roundStart">
            
        </select>
    
        <span><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#40}'; endif;echo translate_smarty(array('id' => 'event_round_time'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#40}'; endif;?>
</span>        
        <?php echo smarty_function_html_select_time(array('prefix' => 'round_start','time' => '12:0:0','display_seconds' => false,'minute_interval' => 5), $this);?>

        
    
        <button href="#" id="addRound"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#41}'; endif;echo translate_smarty(array('id' => 'event_add_round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#41}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#42}'; endif;echo formerror_smarty(array('field' => 'round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#42}'; endif;?>

    </div>
    
    <ul class="editList" id="roundList">
        
    </ul>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#43}'; endif;echo formerror_smarty(array('field' => 'rounds'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#43}'; endif;?>

    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#44}'; endif;echo translate_smarty(array('id' => 'event_management'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#44}'; endif;?>
</h2>
    
    <div>
        <label for="td"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#45}'; endif;echo translate_smarty(array('id' => 'event_td'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#45}'; endif;?>
</label>
        <input type="hidden" name="oldtd" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['oldtd'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input type="text"
               <?php if (! $this->_tpl_vars['allowTdChange']): ?> disabled="true"<?php endif; ?>
               name="td" id="td" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['event']['td'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#46}'; endif;echo formerror_smarty(array('field' => 'td'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#46}'; endif;?>

    </div>
    
    <div>
        <label for="official"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#47}'; endif;echo translate_smarty(array('id' => 'event_official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#47}'; endif;?>
</label>
        <input type="text" name="official" id="official" />
        <button href="#" id="addOfficial"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#48}'; endif;echo translate_smarty(array('id' => 'event_add_official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#48}'; endif;?>
</button>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#49}'; endif;echo formerror_smarty(array('field' => 'official'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#49}'; endif;?>

    </div>
    
    <ul class="editList" id="officialList">
        
    </ul>
    
    <?php if (! $this->_tpl_vars['new']): ?>

        <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#50}'; endif;echo translate_smarty(array('id' => 'event_state'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#50}'; endif;?>
</h2>
        <ul class="nobullets">
            <li><input type="radio" name="event_state" value="preliminary" <?php if ($this->_tpl_vars['event']['event_state'] == 'preliminary' || $this->_tpl_vars['event']['event_state'] == ''): ?>checked="checked"<?php endif; ?> />
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#51}'; endif;echo translate_smarty(array('id' => 'event_state_preliminary'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#51}'; endif;?>
</li>
            <li><input type="radio" name="event_state" value="active" <?php if ($this->_tpl_vars['event']['event_state'] == 'active'): ?>checked="checked"<?php endif; ?> />
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#52}'; endif;echo translate_smarty(array('id' => 'event_state_active'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#52}'; endif;?>
</li>
            <li><input type="radio" name="event_state" value="done" <?php if ($this->_tpl_vars['event']['event_state'] == 'done'): ?>checked="checked"<?php endif; ?> />
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#53}'; endif;echo translate_smarty(array('id' => 'event_state_done'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#53}'; endif;?>
</li>
        </ul>        
    <?php endif; ?>
    
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#54}'; endif;echo formerror_smarty(array('field' => 'officials'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#54}'; endif;?>

    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#55}'; endif;echo translate_smarty(array('id' => 'form_save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#55}'; endif;?>
" name="save" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#56}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#56}'; endif;?>
" name="cancel" />
        <?php if ($this->_tpl_vars['admin'] && ! $this->_tpl_vars['new']): ?>
        <input type="submit" style="margin-left: 96px" id="deleteButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#57}'; endif;echo translate_smarty(array('id' => 'delete'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#57}'; endif;?>
" name="delete" />
        <?php endif; ?>
    </div>
    
</form>


<script type="text/javascript">
//<![CDATA[
var day_index = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#58}'; endif;echo translate_smarty(array('id' => 'day_index'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#58}'; endif;?>
";

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
    
    
    $("#duration").change(durationChanged);
    $("#duration").change();
    
    $("#addAllClasses").click(addAllClasses);
    
    $("#cancelButton").click(CancelSubmit);
    
        
    var options, a;
    jQuery(function(){
    options = { serviceUrl: baseUrl,
        params: { path : \'autocomplete\', id: \'venue\' }};
    a = $(\'#venueField\').autocomplete(options);
    
    
    $(\'#td\').autocomplete(
      { serviceUrl: baseUrl,
        params: { path : \'autocomplete\', id: \'users\'} 
      } 
    );
    $(\'#official\').autocomplete(
      { serviceUrl: baseUrl,
        params: { path : \'autocomplete\', id: \'users\'
      }} 
    );
    $(".useDatePicker").datepicker({
                            dateFormat: \'yy-mm-dd\',
                            changeMonth: true,
                            '; ?>

                            dayNames: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#59}'; endif;echo translate_smarty(array('id' => 'DayNameArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#59}'; endif;?>
],
                            dayNamesShort: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#60}'; endif;echo translate_smarty(array('id' => 'DayNameShortArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#60}'; endif;?>
],
                            dayNamesMin: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#61}'; endif;echo translate_smarty(array('id' => 'DayNameMinArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#61}'; endif;?>
],
                            monthNames: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#62}'; endif;echo translate_smarty(array('id' => 'MonthNameArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#62}'; endif;?>
],
                            monthNamesShort: [<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#63}'; endif;echo translate_smarty(array('id' => 'MonthNameShortArray'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#63}'; endif;?>
],
                            <?php echo '
                            firstDay: 1
                            });
    
    $(\'#addClass\').click(addClass);
    $(\'#addRound\').click(addRound);
    $(\'#addOfficial\').click(addOfficial);
    

});
    
});

function durationChanged() {
    var days = parseInt(this.value);
    if (days < 1) days = 1;
    $("#roundStart").empty();
    var select = $("#roundStart").get(0);
    
    for (ind = 1; ind <= days; ++ind) {
        var option = document.createElement(\'option\');
        option.value = ind;
        option.appendChild(document.createTextNode(day_index + ind));
        select.appendChild(option);
                   
    }
}

function AlwaysEmptyField(field, arguments, initialize) {
    if (initialize) {
	field.blur(TestField);	
    }
    else {
	

        if (!fullTest) return true;	    
	
	if (getvalue(field) == "") return true;
	
	
	'; ?>

	return "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#64}'; endif;echo translate_smarty(array('id' => 'FormError_ShouldBeEmpty','escape' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#64}'; endif;?>
";
	<?php echo '
    }
    
}

var classes = new Array();

'; ?>

var class_already_in_use = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#65}'; endif;echo translate_smarty(array('id' => 'class_already_in_use'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#65}'; endif;?>
";
var confirm_class_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#66}'; endif;echo translate_smarty(array('id' => 'confirm_class_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#66}'; endif;?>
";
var remove_class_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#67}'; endif;echo translate_smarty(array('id' => 'remove_class_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#67}'; endif;?>
";

var confirm_round_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#68}'; endif;echo translate_smarty(array('id' => 'confirm_round_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#68}'; endif;?>
";
var invalid_round ="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#69}'; endif;echo translate_smarty(array('id' => 'invalid_round'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#69}'; endif;?>
";
var remove_round_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#70}'; endif;echo translate_smarty(array('id' => 'remove_round_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#70}'; endif;?>
";
var holesText = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#71}'; endif;echo translate_smarty(array('id' => 'holes'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#71}'; endif;?>
";

var confirm_official_removal = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#72}'; endif;echo translate_smarty(array('id' => 'confirm_official_removal'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#72}'; endif;?>
";
var remove_official_text = "<?php if ($this->caching && !$this->_cache_including): echo '{nocache:497238055e4fe9b3d580268c4599e881#73}'; endif;echo translate_smarty(array('id' => 'remove_official_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:497238055e4fe9b3d580268c4599e881#73}'; endif;?>
";

<?php echo '

function addAllClasses(e) {
    if (e) e.preventDefault();
    var options = $(\'#classList option\');
    options.each(function() {
       var val = this.value;
       if (val == "") return;
       if (!classes[val]) {
        
            addClass(null, val);
        
       }
    });
    return false;
}

function addClass(event, id) {
    if (event) event.preventDefault();
    
    var select = document.getElementById(\'classList\');
    if (!id) id = select.value;
    
    if (id == "") return false;
    
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

function addRound(event, startDate, startTime, roundId) {
    if (!roundId) roundId = "*";
    if (event) event.preventDefault();
    
    var dateElement = document.getElementById(\'roundStart\');
    var hourElement = $(\'select[name="round_startHour"]\').get(0);
    var minuteElement = $(\'select[name="round_startMinute"]\').get(0);
    
    
    
    if (!startDate) startDate = GetSelectText(dateElement);
    if (!startTime) {
        startTime = hourElement.value + ":" + minuteElement.value;
    }
    
    
    var hidden = document.createElement(\'input\');
    hidden.type = \'hidden\';    
    hidden.name = \'roundOperations_\' + getUniqueFieldId();
    hidden.value = \'add:\' + roundIndex + ":" + roundId + ":" + startDate + ":" + startTime;
    
    dateElement.parentNode.appendChild(hidden);
    
    
    var label = document.createElement(\'label\');
    var text = document.createTextNode(startDate + ", " + startTime);
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
", '<?php echo ((is_array($_tmp=$this->_tpl_vars['round']['roundid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');
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