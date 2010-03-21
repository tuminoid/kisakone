<?php /* Smarty version 2.6.26, created on 2010-02-18 19:25:27
         compiled from eventviews/cancelsignup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/cancelsignup.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%42^421^4211ABCC%%cancelsignup.tpl.inc'] = '2aeba0b9604dea70014a8ed4d7305f68'; ?> <?php if ($this->_tpl_vars['mode'] == 'body'): ?>

 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>
    
</div>

<?php if (! $this->_tpl_vars['signupOpen']): ?>
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2aeba0b9604dea70014a8ed4d7305f68#0}'; endif;echo translate_smarty(array('id' => 'cant_cancel_signup_now'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2aeba0b9604dea70014a8ed4d7305f68#0}'; endif;?>
</p>
<?php else: ?>

    <?php if ($this->_tpl_vars['paid']): ?>
    <p><p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2aeba0b9604dea70014a8ed4d7305f68#1}'; endif;echo translate_smarty(array('id' => 'signed_up_and_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2aeba0b9604dea70014a8ed4d7305f68#1}'; endif;?>
</p>
        
    <?php else: ?>
        <p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:2aeba0b9604dea70014a8ed4d7305f68#2}'; endif;echo translate_smarty(array('id' => 'signed_up_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2aeba0b9604dea70014a8ed4d7305f68#2}'; endif;?>
</p>
    
    <?php endif; ?>
    
    <form method="post">
        <input type="hidden" name="formid" value="cancel_signup" />
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2aeba0b9604dea70014a8ed4d7305f68#3}'; endif;echo translate_smarty(array('id' => 'cancelsignup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2aeba0b9604dea70014a8ed4d7305f68#3}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:2aeba0b9604dea70014a8ed4d7305f68#4}'; endif;echo translate_smarty(array('id' => 'abort'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:2aeba0b9604dea70014a8ed4d7305f68#4}'; endif;?>
" />
    </form>
<?php endif; ?>
    
<?php endif; ?>