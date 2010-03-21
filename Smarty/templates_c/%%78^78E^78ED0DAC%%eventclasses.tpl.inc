<?php /* Smarty version 2.6.26, created on 2010-02-18 19:57:56
         compiled from eventclasses.tpl */

$this->_cache_serials['./Smarty/templates_c/%%78^78E^78ED0DAC%%eventclasses.tpl.inc'] = 'd49157a30f5008add1403c2d4e685d7e';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventclasses.tpl', 22, false),array('function', 'url', 'eventclasses.tpl', 32, false),array('function', 'initializeGetFormFields', 'eventclasses.tpl', 33, false),array('function', 'sortheading', 'eventclasses.tpl', 51, false),array('modifier', 'escape', 'eventclasses.tpl', 36, false),)), $this); ?>
<?php
function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_0(&$this)
{
echo translate_smarty(array('id' => 'eventfees_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_1(&$this)
{
echo translate_smarty(array('id' => 'toggle_menu'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_2(&$this)
{
echo url_smarty(array('page' => 'eventclasses','id' => $_GET['id']), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_3(&$this)
{
echo initializeGetFormFields_Smarty(array('search' => false), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_4(&$this)
{
echo translate_smarty(array('id' => 'users_searchhint'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_5(&$this)
{
echo translate_smarty(array('id' => 'users_search'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_6(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_7(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_8(&$this)
{
echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_9(&$this)
{
echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_10(&$this)
{
echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_11(&$this)
{
echo sortheading_smarty(array('field' => 'birthyear','id' => 'birthyear','sortType' => 'integer'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_12(&$this)
{
echo sortheading_smarty(array('field' => 'gender','id' => 'gender','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_13(&$this)
{
echo sortheading_smarty(array('field' => 'class','id' => 'class','sortType' => 'selectText'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_14(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_15(&$this)
{
echo url_smarty(array('page' => 'user','id' => ($this->_tpl_vars['userid'])), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_16(&$this)
{
echo translate_smarty(array('id' => 'male'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_17(&$this)
{
echo translate_smarty(array('id' => 'female'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_18(&$this)
{
echo translate_smarty(array('id' => 'remove_player_from_event'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_19(&$this)
{
echo translate_smarty(array('id' => 'form_save'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_20(&$this)
{
echo translate_smarty(array('id' => 'form_cancel'), $this);
}


function _smarty_tplfunc_d49157a30f5008add1403c2d4e685d7e_21(&$this)
{
echo translate_smarty(array('id' => 'No_Search_Results'), $this);
}



?>
