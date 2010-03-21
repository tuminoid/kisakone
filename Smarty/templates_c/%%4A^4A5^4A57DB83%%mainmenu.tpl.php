<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:07
         compiled from include/mainmenu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'include/mainmenu.tpl', 28, false),array('function', 'translate', 'include/mainmenu.tpl', 28, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%4A^4A5^4A57DB83%%mainmenu.tpl.inc'] = '1a17a3381032a47c7b91fc59f46a8f5e'; ?><?php $this->assign('test', 'a & b'); ?>
<ul id="mainmenu">

    <?php unset($this->_sections['menuitem']);
$this->_sections['menuitem']['name'] = 'menuitem';
$this->_sections['menuitem']['loop'] = is_array($_loop=$this->_tpl_vars['mainmenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['menuitem']['show'] = true;
$this->_sections['menuitem']['max'] = $this->_sections['menuitem']['loop'];
$this->_sections['menuitem']['step'] = 1;
$this->_sections['menuitem']['start'] = $this->_sections['menuitem']['step'] > 0 ? 0 : $this->_sections['menuitem']['loop']-1;
if ($this->_sections['menuitem']['show']) {
    $this->_sections['menuitem']['total'] = $this->_sections['menuitem']['loop'];
    if ($this->_sections['menuitem']['total'] == 0)
        $this->_sections['menuitem']['show'] = false;
} else
    $this->_sections['menuitem']['total'] = 0;
if ($this->_sections['menuitem']['show']):

            for ($this->_sections['menuitem']['index'] = $this->_sections['menuitem']['start'], $this->_sections['menuitem']['iteration'] = 1;
                 $this->_sections['menuitem']['iteration'] <= $this->_sections['menuitem']['total'];
                 $this->_sections['menuitem']['index'] += $this->_sections['menuitem']['step'], $this->_sections['menuitem']['iteration']++):
$this->_sections['menuitem']['rownum'] = $this->_sections['menuitem']['iteration'];
$this->_sections['menuitem']['index_prev'] = $this->_sections['menuitem']['index'] - $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['index_next'] = $this->_sections['menuitem']['index'] + $this->_sections['menuitem']['step'];
$this->_sections['menuitem']['first']      = ($this->_sections['menuitem']['iteration'] == 1);
$this->_sections['menuitem']['last']       = ($this->_sections['menuitem']['iteration'] == $this->_sections['menuitem']['total']);
?>
    <li <?php if ($this->_tpl_vars['mainmenuselection'] == $this->_tpl_vars['mainmenu'][$this->_sections['menuitem']['index']]['title']): ?> class="selected"<?php endif; ?>>
        <a
           href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:1a17a3381032a47c7b91fc59f46a8f5e#0}'; endif;echo url_smarty(array('page' => $this->_tpl_vars['mainmenu'][$this->_sections['menuitem']['index']]['url']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1a17a3381032a47c7b91fc59f46a8f5e#0}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:1a17a3381032a47c7b91fc59f46a8f5e#1}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['mainmenu'][$this->_sections['menuitem']['index']]['title']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:1a17a3381032a47c7b91fc59f46a8f5e#1}'; endif;?>
</a> 
    </li>
    <?php endfor; endif; ?>
    </ul>