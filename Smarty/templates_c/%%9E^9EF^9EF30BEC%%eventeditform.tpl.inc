<?php /* Smarty version 2.6.26, created on 2010-02-15 15:55:42
         compiled from support/eventeditform.tpl */

$this->_cache_serials['./Smarty/templates_c/%%9E^9EF^9EF30BEC%%eventeditform.tpl.inc'] = '497238055e4fe9b3d580268c4599e881';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/eventeditform.tpl', 28, false),array('function', 'formerror', 'support/eventeditform.tpl', 57, false),array('function', 'html_options', 'support/eventeditform.tpl', 70, false),array('function', 'html_select_time', 'support/eventeditform.tpl', 157, false),array('modifier', 'escape', 'support/eventeditform.tpl', 56, false),)), $this); ?>
<?php
function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_0(&$this)
{
echo translate_smarty(array('id' => 'newevent_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_1(&$this)
{
echo translate_smarty(array('id' => 'editevent_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_2(&$this)
{
echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_3(&$this)
{
echo translate_smarty(array('id' => 'month_default','assign' => 'month_default'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_4(&$this)
{
echo translate_smarty(array('id' => 'day_default','assign' => 'day_default'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_5(&$this)
{
echo translate_smarty(array('id' => 'page_requires_javascript'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_6(&$this)
{
echo translate_smarty(array('id' => 'newevent_title'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_7(&$this)
{
echo translate_smarty(array('id' => 'editevent_title'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_8(&$this)
{
echo translate_smarty(array('id' => 'event_name'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_9(&$this)
{
echo formerror_smarty(array('field' => 'name'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_10(&$this)
{
echo translate_smarty(array('id' => 'event_venue'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_11(&$this)
{
echo formerror_smarty(array('field' => 'venue'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_12(&$this)
{
echo translate_smarty(array('id' => 'event_tournament'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_13(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_14(&$this)
{
echo formerror_smarty(array('field' => 'tournament'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_15(&$this)
{
echo translate_smarty(array('id' => 'event_level'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_16(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_17(&$this)
{
echo formerror_smarty(array('field' => 'level'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_18(&$this)
{
echo translate_smarty(array('id' => 'event_start'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_19(&$this)
{
echo formerror_smarty(array('field' => 'start'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_20(&$this)
{
echo translate_smarty(array('id' => 'event_duration'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_21(&$this)
{
echo translate_smarty(array('id' => 'event_duration_days'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_22(&$this)
{
echo formerror_smarty(array('field' => 'duration'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_23(&$this)
{
echo translate_smarty(array('id' => 'event_signup_start'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_24(&$this)
{
echo formerror_smarty(array('field' => 'signup_start'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_25(&$this)
{
echo translate_smarty(array('id' => 'event_signup_end'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_26(&$this)
{
echo formerror_smarty(array('field' => 'signup_end'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_27(&$this)
{
echo translate_smarty(array('id' => 'event_contact'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_28(&$this)
{
echo formerror_smarty(array('field' => 'contact'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_29(&$this)
{
echo translate_smarty(array('id' => 'event_require_member_fee'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_30(&$this)
{
echo translate_smarty(array('id' => 'event_require_license_fee'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_31(&$this)
{
echo translate_smarty(array('id' => 'event_classes'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_32(&$this)
{
echo translate_smarty(array('id' => 'event_classes'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_33(&$this)
{
echo translate_smarty(array('id' => 'select_none'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_34(&$this)
{
echo translate_smarty(array('id' => 'event_add_class'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_35(&$this)
{
echo translate_smarty(array('id' => 'event_add_all_classes'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_36(&$this)
{
echo formerror_smarty(array('field' => 'classList_'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_37(&$this)
{
echo formerror_smarty(array('field' => 'classes'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_38(&$this)
{
echo translate_smarty(array('id' => 'event_rounds'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_39(&$this)
{
echo translate_smarty(array('id' => 'round_start_time'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_40(&$this)
{
echo translate_smarty(array('id' => 'event_round_time'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_41(&$this)
{
echo translate_smarty(array('id' => 'event_add_round'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_42(&$this)
{
echo formerror_smarty(array('field' => 'round'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_43(&$this)
{
echo formerror_smarty(array('field' => 'rounds'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_44(&$this)
{
echo translate_smarty(array('id' => 'event_management'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_45(&$this)
{
echo translate_smarty(array('id' => 'event_td'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_46(&$this)
{
echo formerror_smarty(array('field' => 'td'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_47(&$this)
{
echo translate_smarty(array('id' => 'event_official'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_48(&$this)
{
echo translate_smarty(array('id' => 'event_add_official'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_49(&$this)
{
echo formerror_smarty(array('field' => 'official'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_50(&$this)
{
echo translate_smarty(array('id' => 'event_state'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_51(&$this)
{
echo translate_smarty(array('id' => 'event_state_preliminary'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_52(&$this)
{
echo translate_smarty(array('id' => 'event_state_active'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_53(&$this)
{
echo translate_smarty(array('id' => 'event_state_done'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_54(&$this)
{
echo formerror_smarty(array('field' => 'officials'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_55(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_56(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_57(&$this)
{
echo translate_smarty(array('id' => 'delete'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_58(&$this)
{
echo translate_smarty(array('id' => 'day_index'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_59(&$this)
{
echo translate_smarty(array('id' => 'DayNameArray'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_60(&$this)
{
echo translate_smarty(array('id' => 'DayNameShortArray'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_61(&$this)
{
echo translate_smarty(array('id' => 'DayNameMinArray'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_62(&$this)
{
echo translate_smarty(array('id' => 'MonthNameArray'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_63(&$this)
{
echo translate_smarty(array('id' => 'MonthNameShortArray'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_64(&$this)
{
echo translate_smarty(array('id' => 'FormError_ShouldBeEmpty','escape' => false), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_65(&$this)
{
echo translate_smarty(array('id' => 'class_already_in_use'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_66(&$this)
{
echo translate_smarty(array('id' => 'confirm_class_removal'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_67(&$this)
{
echo translate_smarty(array('id' => 'remove_class_text'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_68(&$this)
{
echo translate_smarty(array('id' => 'confirm_round_removal'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_69(&$this)
{
echo translate_smarty(array('id' => 'invalid_round'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_70(&$this)
{
echo translate_smarty(array('id' => 'remove_round_text'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_71(&$this)
{
echo translate_smarty(array('id' => 'holes'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_72(&$this)
{
echo translate_smarty(array('id' => 'confirm_official_removal'), $this);
}


function _smarty_tplfunc_497238055e4fe9b3d580268c4599e881_73(&$this)
{
echo translate_smarty(array('id' => 'remove_official_text'), $this);
}



?>
