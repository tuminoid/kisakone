<?php /* Smarty version 2.6.26, created on 2010-02-13 17:03:27
         compiled from manageevent_official.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'manageevent_official.tpl', 25, false),array('function', 'submenulinks', 'manageevent_official.tpl', 26, false),array('function', 'math', 'manageevent_official.tpl', 31, false),array('function', 'url', 'manageevent_official.tpl', 32, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%AB^AB2^AB22DAAC%%manageevent_official.tpl.inc'] = '88c2ff80068a9552662067616953d52a'; ?><?php $this->assign('title', $this->_tpl_vars['event']->name); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:88c2ff80068a9552662067616953d52a#0}'; endif;echo translate_smarty(array('id' => 'manage_event_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:88c2ff80068a9552662067616953d52a#0}'; endif;?>

<?php echo submenulinks_smarty(array(), $this);?>


<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:88c2ff80068a9552662067616953d52a#1}'; endif;echo translate_smarty(array('id' => 'print_score_cards_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:88c2ff80068a9552662067616953d52a#1}'; endif;?>
</p>
<ul>
<?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
    <?php echo smarty_function_math(array('assign' => 'roundnum','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

    <li><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:88c2ff80068a9552662067616953d52a#2}'; endif;echo url_smarty(array('page' => 'printscorecard','round' => $this->_tpl_vars['roundnum'],'id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:88c2ff80068a9552662067616953d52a#2}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:88c2ff80068a9552662067616953d52a#3}'; endif;echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['roundnum']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:88c2ff80068a9552662067616953d52a#3}'; endif;?>
</a>
    <?php if (! $this->_tpl_vars['round']->groupsFinished): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:88c2ff80068a9552662067616953d52a#4}'; endif;echo translate_smarty(array('id' => 'preliminary'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:88c2ff80068a9552662067616953d52a#4}'; endif;?>
<?php endif; ?>
    </li>
<?php endforeach; endif; unset($_from); ?>
</ul>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array('noad' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 