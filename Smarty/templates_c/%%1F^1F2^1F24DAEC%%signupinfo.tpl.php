<?php /* Smarty version 2.6.26, created on 2010-02-15 16:09:28
         compiled from eventviews/signupinfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/signupinfo.tpl', 29, false),array('function', 'url', 'eventviews/signupinfo.tpl', 67, false),array('modifier', 'escape', 'eventviews/signupinfo.tpl', 55, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%1F^1F2^1F24DAEC%%signupinfo.tpl.inc'] = '6c509ed0d6b8802afb9d7b2474bc9146'; ?><?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>
    
</div>


<?php if ($this->_tpl_vars['admin']): ?>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#0}'; endif;echo translate_smarty(array('id' => 'admin_cant_sign_up'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#0}'; endif;?>
</p>
<?php $this->assign('nosignup', true); ?>
<?php elseif (! $this->_tpl_vars['user']): ?>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#1}'; endif;echo translate_smarty(array('id' => 'login_to_sign_up'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#1}'; endif;?>
</p>
<?php $this->assign('nosignup', true); ?>
<?php elseif ($this->_tpl_vars['feesMissing']): ?>
    <?php if ($this->_tpl_vars['feesMissing'] == 1): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#2}'; endif;echo translate_smarty(array('id' => 'fees_necessary_for_signup_1'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#2}'; endif;?>
</p>
    <?php elseif ($this->_tpl_vars['feesMissing'] == 2): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#3}'; endif;echo translate_smarty(array('id' => 'fees_necessary_for_signup_2'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#3}'; endif;?>
</p>
    <?php elseif ($this->_tpl_vars['feesMissing'] == 3): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#4}'; endif;echo translate_smarty(array('id' => 'fees_necessary_for_signup_3'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#4}'; endif;?>
</p>
    <?php endif; ?>
<?php $this->assign('nosignup', true); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['admin'] || ( ! $this->_tpl_vars['signedup'] && $this->_tpl_vars['signupOpen'] )): ?>

<form method="post" class="">
    <input type="hidden" name="formid" value="sign_up" />
    <?php if ($this->_tpl_vars['user']): ?>
        <p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#5}'; endif;echo translate_smarty(array('id' => 'not_signed_up'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#5}'; endif;?>
</p>
        <?php $this->assign('player', $this->_tpl_vars['user']->getPlayer()); ?>        
        <?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['class']):
?>
            <div>
                <input type="radio" name="class" id="class" value="<?php echo $this->_tpl_vars['class']->id; ?>
" <?php if (! $this->_tpl_vars['player'] || ! $this->_tpl_vars['player']->isSuitableClass($this->_tpl_vars['class']) || $this->_tpl_vars['nosignup']): ?>disabled="disabled"<?php endif; ?> />
                <label><?php echo ((is_array($_tmp=$this->_tpl_vars['class']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</label>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        
        <hr style="clear: both" />
        <input type="submit" <?php if ($this->_tpl_vars['nosignup']): ?>disabled="disabled"<?php endif; ?> value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#6}'; endif;echo translate_smarty(array('id' => 'signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#6}'; endif;?>
" />
        <input type="submit" id="cancel" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#7}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#7}'; endif;?>
" />
    <?php endif; ?>
</form>
<?php elseif ($this->_tpl_vars['paid']): ?>
    <p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#8}'; endif;echo translate_smarty(array('id' => 'signed_up_and_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#8}'; endif;?>
</p>
    <ul>
        <li><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#9}'; endif;echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#9}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#10}'; endif;echo translate_smarty(array('id' => 'cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#10}'; endif;?>
</a></li>    
    </ul>
<?php elseif ($this->_tpl_vars['signedup'] && ! $this->_tpl_vars['paid']): ?>
    <p class="signup_status"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#11}'; endif;echo translate_smarty(array('id' => 'signed_up_not_paid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#11}'; endif;?>
</p>
    <ul>
        <li><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#12}'; endif;echo url_smarty(array('page' => 'event','view' => 'payment','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#12}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#13}'; endif;echo translate_smarty(array('id' => 'event_payment'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#13}'; endif;?>
</a></li>    
        <li><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#14}'; endif;echo url_smarty(array('page' => 'event','view' => 'cancelsignup','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#15}'; endif;echo translate_smarty(array('id' => 'cancel_signup'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#15}'; endif;?>
</a></li>    
    </ul>
<?php else: ?>
    <p>
    <?php if ($this->_tpl_vars['signupStart']): ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#16}'; endif;echo translate_smarty(array('id' => 'signup_closed_dates','from' => $this->_tpl_vars['signupStart'],'to' => $this->_tpl_vars['signupEnd']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#16}'; endif;?>

    <?php else: ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:6c509ed0d6b8802afb9d7b2474bc9146#17}'; endif;echo translate_smarty(array('id' => 'signup_closed'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:6c509ed0d6b8802afb9d7b2474bc9146#17}'; endif;?>

    <?php endif; ?>
    </p>
<?php endif; ?>
    
<?php endif; ?>