<?php /* Smarty version 2.6.26, created on 2010-02-16 14:54:39
         compiled from managerounds.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'managerounds.tpl', 22, false),array('function', 'url', 'managerounds.tpl', 27, false),array('function', 'counter', 'managerounds.tpl', 36, false),array('function', 'math', 'managerounds.tpl', 38, false),array('modifier', 'date_format', 'managerounds.tpl', 45, false),array('modifier', 'escape', 'managerounds.tpl', 75, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%D5^D57^D57954C4%%managerounds.tpl.inc'] = '5dd4cc673e5ae49e663133a537215a2e'; ?> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'managerounds_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "support/eventlockhelper.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php ob_start(); ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#1}'; endif;echo url_smarty(array('page' => 'managecourses','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#1}'; endif;?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('link', ob_get_contents());ob_end_clean(); ?>
<p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#2}'; endif;echo translate_smarty(array('id' => 'round_course_edit_help','link' => $this->_tpl_vars['link']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#2}'; endif;?>
</p>

<form method="post">
    <input type="hidden" name="formid" value="manage_rounds" />
    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#3}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#3}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#4}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#4}'; endif;?>
" />
    </div>
    <?php echo smarty_function_counter(array('start' => 0,'assign' => 'globalHole'), $this);?>

    <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
        <?php echo smarty_function_math(array('assign' => 'number','equation' => "x + 1",'x' => $this->_tpl_vars['index']), $this);?>

        <div class="round">
            <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#5}'; endif;echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['number']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#5}'; endif;?>
</h2>
            <table class="narrow">
                <tr>
                                        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#6}'; endif;echo translate_smarty(array('id' => 'date'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#6}'; endif;?>
</td>
                    <td><input type="text" name="<?php echo $this->_tpl_vars['round']->id; ?>
_date" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['round']->starttime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
" /></td>
                </tr>
                <tr>
                    <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#7}'; endif;echo translate_smarty(array('id' => 'starttype'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#7}'; endif;?>
</td>
                    <td>
                        <input type="radio" name="<?php echo $this->_tpl_vars['round']->id; ?>
_starttype" value="sequential"
                               <?php if ($this->_tpl_vars['round']->starttype == 'sequential'): ?> checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#8}'; endif;echo translate_smarty(array('id' => 'sequential'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#8}'; endif;?>
 <br />
                        <input type="radio" name="<?php echo $this->_tpl_vars['round']->id; ?>
_starttype" value="simultaneous"
                               <?php if ($this->_tpl_vars['round']->starttype == 'simultaneous'): ?> checked="checked"<?php endif; ?>
                               /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#9}'; endif;echo translate_smarty(array('id' => 'simultaneous'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#9}'; endif;?>
 <br />
                    </td>
                    
                </tr>
                <tr>                   
                    <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#10}'; endif;echo translate_smarty(array('id' => 'group_interval'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#10}'; endif;?>
</td>
                    <td><input type="text" name="<?php echo $this->_tpl_vars['round']->id; ?>
_interval" value="<?php echo $this->_tpl_vars['round']->interval; ?>
" /></td>
                </tr>
                <tr>                   
                    
                    <td colspan="2">
                        <input type="checkbox" name="<?php echo $this->_tpl_vars['round']->id; ?>
_valid" <?php if ($this->_tpl_vars['round']->validresults): ?>checked="checked"<?php endif; ?> />
                        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#11}'; endif;echo translate_smarty(array('id' => 'round_valid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#11}'; endif;?>

                    </td>
                </tr>
                <tr>
                    <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#12}'; endif;echo translate_smarty(array('id' => 'round_course'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#12}'; endif;?>
</td>
                    <td>
                        <select name="<?php echo $this->_tpl_vars['round']->id; ?>
_course">
                            <option value=""><?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#13}'; endif;echo translate_smarty(array('id' => 'select_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#13}'; endif;?>
</option>
                            <?php $_from = $this->_tpl_vars['courses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['course']):
?>
                                <option value="<?php echo $this->_tpl_vars['course']['id']; ?>
" <?php if ($this->_tpl_vars['round']->course == $this->_tpl_vars['course']['id']): ?>selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['course']['Name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </td>
                </tr>
            </table>
            
        </div>
    <?php endforeach; endif; unset($_from); ?>
    
    <div  class="buttonarea">
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#14}'; endif;echo translate_smarty(array('id' => 'save'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#14}'; endif;?>
" />
        <input type="submit" name="cancel" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:5dd4cc673e5ae49e663133a537215a2e#15}'; endif;echo translate_smarty(array('id' => 'cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:5dd4cc673e5ae49e663133a537215a2e#15}'; endif;?>
" />
    </div>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "include/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>