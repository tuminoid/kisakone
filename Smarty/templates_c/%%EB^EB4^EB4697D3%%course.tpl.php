<?php /* Smarty version 2.6.26, created on 2010-02-16 14:46:23
         compiled from eventviews/course.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'eventviews/course.tpl', 29, false),array('function', 'translate', 'eventviews/course.tpl', 32, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%EB^EB4^EB4697D3%%course.tpl.inc'] = '9ecb12720bd72fc51fab7500928fdaa1'; ?> <?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>

<?php $_from = $this->_tpl_vars['courses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['course']):
?>
    
    <h3><?php echo $this->_tpl_vars['course']['Rounds']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
    <div><?php echo $this->_tpl_vars['course']['Description']; ?>
</div>
    <?php if ($this->_tpl_vars['course']['Link']): ?>
    <p><a href="<?php echo $this->_tpl_vars['course']['Link']; ?>
" target="_blank"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#0}'; endif;echo translate_smarty(array('id' => 'course_details'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#0}'; endif;?>
</a></p>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['course']['Map']): ?>
        <img style="float: right" src="<?php echo $this->_tpl_vars['course']['Map']; ?>
" alt="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#1}'; endif;echo translate_smarty(array('id' => 'course_map'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#1}'; endif;?>
" />
    <?php endif; ?>
    
    <h4><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#2}'; endif;echo translate_smarty(array('id' => 'holes_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#2}'; endif;?>
</h4>
    <table class="narrow">
        <?php if (true || $this->_tpl_vars['course']['Map']): ?>
                    <tr>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#3}'; endif;echo translate_smarty(array('id' => 'holeNumber'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#3}'; endif;?>
</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#4}'; endif;echo translate_smarty(array('id' => 'par'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#4}'; endif;?>
</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#5}'; endif;echo translate_smarty(array('id' => 'length'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#5}'; endif;?>
</th>
            </tr>
            <?php $_from = $this->_tpl_vars['course']['Holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
            <tr>
                <td><?php echo $this->_tpl_vars['hole']->holeNumber; ?>
</td>
                 <td><?php echo $this->_tpl_vars['hole']->par; ?>
</td>
                 <td><?php echo $this->_tpl_vars['hole']->length; ?>
</td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            
           
        <?php else: ?>
            <tr>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#6}'; endif;echo translate_smarty(array('id' => 'holeNumber'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#6}'; endif;?>
</th>
                <?php $_from = $this->_tpl_vars['course']['Holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
                    <td><?php echo $this->_tpl_vars['hole']->holeNumber; ?>
</td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
            <tr>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#7}'; endif;echo translate_smarty(array('id' => 'par'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#7}'; endif;?>
</th>
                <?php $_from = $this->_tpl_vars['course']['Holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
                    <td><?php echo $this->_tpl_vars['hole']->par; ?>
</td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
            <tr>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:9ecb12720bd72fc51fab7500928fdaa1#8}'; endif;echo translate_smarty(array('id' => 'length'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:9ecb12720bd72fc51fab7500928fdaa1#8}'; endif;?>
</th>
                <?php $_from = $this->_tpl_vars['course']['Holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hole']):
?>
                    <td><?php echo $this->_tpl_vars['hole']->length; ?>
</td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
        <?php endif; ?>
    </table>
<hr style="clear: both" />
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>