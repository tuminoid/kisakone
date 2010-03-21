<?php /* Smarty version 2.6.26, created on 2010-02-16 14:46:58
         compiled from eventviews/payment.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/payment.tpl', 28, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%BA^BAE^BAE1D1F7%%payment.tpl.inc'] = 'f44697c4691805ff0c398a8fec0bcb84'; ?><?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>
    
</div>

<?php if (! $this->_tpl_vars['user']): ?>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f44697c4691805ff0c398a8fec0bcb84#0}'; endif;echo translate_smarty(array('id' => 'login_to_sign_up'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f44697c4691805ff0c398a8fec0bcb84#0}'; endif;?>
</p>
<?php elseif (! $this->_tpl_vars['signedup']): ?>
<p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f44697c4691805ff0c398a8fec0bcb84#1}'; endif;echo translate_smarty(array('id' => 'not_signed_up_nothere'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f44697c4691805ff0c398a8fec0bcb84#1}'; endif;?>
</p>
<?php elseif ($this->_tpl_vars['paid']): ?>
<p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f44697c4691805ff0c398a8fec0bcb84#2}'; endif;echo translate_smarty(array('id' => 'signed_up_and_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f44697c4691805ff0c398a8fec0bcb84#2}'; endif;?>
</p>
    
<?php else: ?>
    <p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:f44697c4691805ff0c398a8fec0bcb84#3}'; endif;echo translate_smarty(array('id' => 'signed_up_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:f44697c4691805ff0c398a8fec0bcb84#3}'; endif;?>
</p>
    
<?php endif; ?>
<?php endif; ?>