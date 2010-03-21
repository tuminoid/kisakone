<?php /* Smarty version 2.6.26, created on 2010-01-30 08:17:18
         compiled from support/eventEditForm.tpl */

$this->_cache_serials['./Smarty/templates_c/%%7F^7FB^7FB4B242%%eventEditForm.tpl.inc'] = '72e004ededd9da154fc969b244f961f5';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/eventEditForm.tpl', 5, false),array('function', 'formerror', 'support/eventEditForm.tpl', 33, false),array('function', 'html_options', 'support/eventEditForm.tpl', 46, false),array('modifier', 'escape', 'support/eventEditForm.tpl', 32, false),)), $this); ?>
<?php
function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_0(&$this)
{
echo translate_smarty(array('id' => 'newevent_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_1(&$this)
{
echo translate_smarty(array('id' => 'editevent_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_2(&$this)
{
echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_3(&$this)
{
echo translate_smarty(array('id' => 'month_default','assign' => 'month_default'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_4(&$this)
{
echo translate_smarty(array('id' => 'day_default','assign' => 'day_default'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_5(&$this)
{
echo translate_smarty(array('id' => 'page_requires_javascript'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_6(&$this)
{
echo translate_smarty(array('id' => 'newevent_title'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_7(&$this)
{
echo translate_smarty(array('id' => 'editevent_title'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_8(&$this)
{
echo translate_smarty(array('id' => 'event_name'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_9(&$this)
{
echo formerror_smarty(array('field' => 'name'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_10(&$this)
{
echo translate_smarty(array('id' => 'event_venue'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_11(&$this)
{
echo formerror_smarty(array('field' => 'venue'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_12(&$this)
{
echo translate_smarty(array('id' => 'event_tournament'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_13(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_14(&$this)
{
echo formerror_smarty(array('field' => 'tournament'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_15(&$this)
{
echo translate_smarty(array('id' => 'event_level'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_16(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_17(&$this)
{
echo formerror_smarty(array('field' => 'level'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_18(&$this)
{
echo translate_smarty(array('id' => 'event_start'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_19(&$this)
{
echo formerror_smarty(array('field' => 'start'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_20(&$this)
{
echo translate_smarty(array('id' => 'event_duration'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_21(&$this)
{
echo translate_smarty(array('id' => 'event_duration_days'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_22(&$this)
{
echo formerror_smarty(array('field' => 'duration'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_23(&$this)
{
echo translate_smarty(array('id' => 'event_signup_start'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_24(&$this)
{
echo formerror_smarty(array('field' => 'signup_start'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_25(&$this)
{
echo translate_smarty(array('id' => 'event_signup_end'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_26(&$this)
{
echo formerror_smarty(array('field' => 'signup_end'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_27(&$this)
{
echo translate_smarty(array('id' => 'event_contact'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_28(&$this)
{
echo formerror_smarty(array('field' => 'contact'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_29(&$this)
{
echo translate_smarty(array('id' => 'event_activate'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_30(&$this)
{
echo translate_smarty(array('id' => 'event_classes'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_31(&$this)
{
echo translate_smarty(array('id' => 'event_classes'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_32(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_33(&$this)
{
echo translate_smarty(array('id' => 'event_add_class'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_34(&$this)
{
echo formerror_smarty(array('field' => 'classList_'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_35(&$this)
{
echo formerror_smarty(array('field' => 'classes'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_36(&$this)
{
echo translate_smarty(array('id' => 'event_rounds'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_37(&$this)
{
echo translate_smarty(array('id' => 'round_start_time'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_38(&$this)
{
echo translate_smarty(array('id' => 'event_round_time'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_39(&$this)
{
echo translate_smarty(array('id' => 'event_round_holes'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_40(&$this)
{
echo translate_smarty(array('id' => 'event_add_round'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_41(&$this)
{
echo formerror_smarty(array('field' => 'round'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_42(&$this)
{
echo formerror_smarty(array('field' => 'rounds'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_43(&$this)
{
echo translate_smarty(array('id' => 'event_management'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_44(&$this)
{
echo translate_smarty(array('id' => 'event_td'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_45(&$this)
{
echo formerror_smarty(array('field' => 'td'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_46(&$this)
{
echo translate_smarty(array('id' => 'event_official'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_47(&$this)
{
echo translate_smarty(array('id' => 'event_add_official'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_48(&$this)
{
echo formerror_smarty(array('field' => 'official'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_49(&$this)
{
echo formerror_smarty(array('field' => 'officials'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_50(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_51(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_52(&$this)
{
echo translate_smarty(array('id' => 'DayNameArray'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_53(&$this)
{
echo translate_smarty(array('id' => 'DayNameShortArray'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_54(&$this)
{
echo translate_smarty(array('id' => 'DayNameMinArray'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_55(&$this)
{
echo translate_smarty(array('id' => 'MonthNameArray'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_56(&$this)
{
echo translate_smarty(array('id' => 'MonthNameShortArray'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_57(&$this)
{
echo translate_smarty(array('id' => 'FormError_ShouldBeEmpty','escape' => false), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_58(&$this)
{
echo translate_smarty(array('id' => 'class_already_in_use'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_59(&$this)
{
echo translate_smarty(array('id' => 'confirm_class_removal'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_60(&$this)
{
echo translate_smarty(array('id' => 'remove_class_text'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_61(&$this)
{
echo translate_smarty(array('id' => 'confirm_round_removal'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_62(&$this)
{
echo translate_smarty(array('id' => 'invalid_round'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_63(&$this)
{
echo translate_smarty(array('id' => 'remove_round_text'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_64(&$this)
{
echo translate_smarty(array('id' => 'holes'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_65(&$this)
{
echo translate_smarty(array('id' => 'confirm_official_removal'), $this);
}


function _smarty_tplfunc_72e004ededd9da154fc969b244f961f5_66(&$this)
{
echo translate_smarty(array('id' => 'remove_official_text'), $this);
}



?>
