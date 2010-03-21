<?php /* Smarty version 2.6.26, created on 2010-02-16 14:50:37
         compiled from support/eventlockhelper.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'support/eventlockhelper.tpl', 24, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%E6^E6B^E6BAC402%%eventlockhelper.tpl.inc'] = '19a99f468d3aae11bbaa7bc7647a0ca1'; ?> <?php if ($this->_tpl_vars['locked']): ?>
    <p class="error"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:19a99f468d3aae11bbaa7bc7647a0ca1#0}'; endif;echo translate_smarty(array('id' => 'event_is_locked_cant_edit'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:19a99f468d3aae11bbaa7bc7647a0ca1#0}'; endif;?>
</p>
    <script type="text/javascript">
    //<![CDATA[
    <?php echo '
    $(document).ready(function(){
        $("input").each(function(){this.disabled=true;});
        $("select").each(function(){this.disabled=true;});
        $("button").each(function(){this.disabled=true;});
    });
    
    '; ?>

    
    
    //]]>
    </script> 
<?php endif; ?>