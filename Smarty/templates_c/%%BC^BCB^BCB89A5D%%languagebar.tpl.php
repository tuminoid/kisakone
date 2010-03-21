<?php /* Smarty version 2.6.26, created on 2010-02-15 16:25:12
         compiled from include/languagebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'include/languagebar.tpl', 39, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%BC^BCB^BCB89A5D%%languagebar.tpl.inc'] = '6a72dcdb82a027ebbb688fd2814e0982'; ?>
<style type="text/css"><?php echo '
    .languagebar {
        float: right;
        text-align: center;
        width: auto !important;
        
    }
    
    .languagebar td {
        vertical-align: middle;
        
    }
'; ?>
</style>
<table class="languagebar">
<tr><td>
<?php if ($this->_tpl_vars['language'] == 'fi-FI'): ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6a72dcdb82a027ebbb688fd2814e0982#0}'; endif;echo translate_smarty(array('id' => "language-fi-FI"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6a72dcdb82a027ebbb688fd2814e0982#0}'; endif;?>

<?php else: ?>
    <a href="?action=set_language&amp;language=fi-FI"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6a72dcdb82a027ebbb688fd2814e0982#1}'; endif;echo translate_smarty(array('id' => "language-fi-FI"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6a72dcdb82a027ebbb688fd2814e0982#1}'; endif;?>
</a>
<?php endif; ?>
</td><td>
<?php if ($this->_tpl_vars['language'] == 'sv'): ?>
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6a72dcdb82a027ebbb688fd2814e0982#2}'; endif;echo translate_smarty(array('id' => "language-sv"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6a72dcdb82a027ebbb688fd2814e0982#2}'; endif;?>

<?php else: ?>
    <a href="?action=set_language&amp;language=sv"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6a72dcdb82a027ebbb688fd2814e0982#3}'; endif;echo translate_smarty(array('id' => "language-sv"), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6a72dcdb82a027ebbb688fd2814e0982#3}'; endif;?>
</a>
<?php endif; ?>
</td><td><a href="?action=set_language&amp;language=RESET">[RESET_LANGUAGE]</a></td>
</tr></table>   