<?php /* Smarty version 2.6.26, created on 2010-02-15 16:58:44
         compiled from tournaments.tpl */

$this->_cache_serials['./Smarty/templates_c/%%6A^6AD^6AD6E323%%tournaments.tpl.inc'] = 'b2d8606373819dbae2ec36316ab17d99';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'tournaments.tpl', 22, false),array('function', 'sortheading', 'tournaments.tpl', 34, false),array('function', 'url', 'tournaments.tpl', 45, false),array('modifier', 'escape', 'tournaments.tpl', 45, false),)), $this); ?>
<?php
function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_0(&$this)
{
echo translate_smarty(array('id' => 'tournaments_title','assign' => 'title'), $this);
}


function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_1(&$this)
{
echo translate_smarty(array('id' => 'tournaments'), $this);
}


function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_2(&$this)
{
echo sortheading_smarty(array('id' => 'tournament_name','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_3(&$this)
{
echo sortheading_smarty(array('id' => 'tournament_participants','sortType' => 'integer'), $this);
}


function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_4(&$this)
{
echo sortheading_smarty(array('id' => 'tournament_events_held','sortType' => 'alphabetical'), $this);
}


function _smarty_tplfunc_b2d8606373819dbae2ec36316ab17d99_5(&$this)
{
echo url_smarty(array('page' => 'tournament','id' => $this->_tpl_vars['t']->id), $this);
}



?>
