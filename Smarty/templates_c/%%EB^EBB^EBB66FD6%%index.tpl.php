<?php /* Smarty version 2.6.26, created on 2010-02-15 15:48:13
         compiled from eventviews/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'eventviews/index.tpl', 29, false),array('function', 'math', 'eventviews/index.tpl', 77, false),array('function', 'url', 'eventviews/index.tpl', 97, false),array('modifier', 'escape', 'eventviews/index.tpl', 30, false),array('modifier', 'date_format', 'eventviews/index.tpl', 79, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%EB^EBB^EBB66FD6%%index.tpl.inc'] = 'e859e5cb2e30c170c3238909bdbf8f3d'; ?> <?php if ($this->_tpl_vars['mode'] == 'body'): ?>
 <div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>
    
</div>

<table class="narrow">
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#0}'; endif;echo translate_smarty(array('id' => 'event_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#0}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
    
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#1}'; endif;echo translate_smarty(array('id' => 'event_venue'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#1}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->venue)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
    
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#2}'; endif;echo translate_smarty(array('id' => 'event_date'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#2}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->fulldate)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
    
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#3}'; endif;echo translate_smarty(array('id' => 'event_level'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#3}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->level)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
    
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#4}'; endif;echo translate_smarty(array('id' => 'event_tournament'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#4}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['event']->tournament)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
    </tr>
    <tr>
        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#5}'; endif;echo translate_smarty(array('id' => 'event_contact'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#5}'; endif;?>
</td>
        <td id="contactInfo"><div style="font-family: monospace"><?php echo $this->_tpl_vars['contactInfoHTML']; ?>
</div></td>        
    </tr>
    

    
    
</table>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#6}'; endif;echo translate_smarty(array('id' => 'schedule'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#6}'; endif;?>
</h2>

<?php echo $this->_tpl_vars['index_schedule_text']; ?>


<table>
   <tr>
    <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#7}'; endif;echo translate_smarty(array('id' => 'round_number','number' => ''), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#7}'; endif;?>
</th>
    <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#8}'; endif;echo translate_smarty(array('id' => 'round_starttime'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#8}'; endif;?>
</th>
    <?php if ($this->_tpl_vars['groups']): ?>
    <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#9}'; endif;echo translate_smarty(array('id' => 'your_group_is'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#9}'; endif;?>
</th>    
    <?php endif; ?>
    </tr>
    <?php $_from = $this->_tpl_vars['rounds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['round']):
?>
    
    <tr>
        <?php echo smarty_function_math(array('assign' => 'number','equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>

        <td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#10}'; endif;echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['number']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#10}'; endif;?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['round']->starttime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M")); ?>
</td>
        
        <?php $this->assign('group', $this->_tpl_vars['groups'][$this->_tpl_vars['index']]); ?>
        <?php if ($this->_tpl_vars['group']): ?>
        <td>
            <?php if ($this->_tpl_vars['round']->starttype == 'sequential'): ?>
        <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['group']['StartingTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('groupstart', ob_get_contents());ob_end_clean(); ?>
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#11}'; endif;echo translate_smarty(array('id' => 'your_group_starting','start' => $this->_tpl_vars['groupstart']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#11}'; endif;?>

        <?php if ($this->_tpl_vars['round']->groupsFinished === null): ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#12}'; endif;echo translate_smarty(array('id' => 'preliminary'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#12}'; endif;?>
<?php endif; ?>
      <?php else: ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#13}'; endif;echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['group']['StartingHole']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#13}'; endif;?>
<?php endif; ?>
   </td>
        <?php endif; ?>
        
    </tr>
    <?php endforeach; endif; unset($_from); ?>

</table>

<p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#14}'; endif;echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'schedule'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#14}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#15}'; endif;echo translate_smarty(array('id' => 'full_schedule'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#15}'; endif;?>
</a></p>

<h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#16}'; endif;echo translate_smarty(array('id' => 'relevant_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#16}'; endif;?>
</h2>

<?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'eventviews/newsitem.tpl', 'smarty_include_vars' => array('item' => $this->_tpl_vars['item'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endforeach; endif; unset($_from); ?>

<?php if (count ( $this->_tpl_vars['news'] )): ?>
    <p><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#17}'; endif;echo url_smarty(array('page' => 'event','id' => $_GET['id'],'view' => 'newsarchive'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#17}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#18}'; endif;echo translate_smarty(array('id' => 'news_archive'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#18}'; endif;?>
</a></p>
    <?php else: ?>
    <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:e859e5cb2e30c170c3238909bdbf8f3d#19}'; endif;echo translate_smarty(array('id' => 'no_news'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:e859e5cb2e30c170c3238909bdbf8f3d#19}'; endif;?>
</p>
<?php endif; ?>


<script type="text/javascript">
//<![CDATA[
var ci = new Array();
<?php echo $this->_tpl_vars['contactInfoJS']; ?>


<?php echo '

function getContactInfo() {
    var str = \'\';
    
    
    for (var i = 0; i < ci.length; ++i) {
        str += ci[i];
    }

    return str;
}

$(document).ready(function(){
    
    $("#contactInfo").empty();
    $("#contactInfo").get(0).appendChild(document.createTextNode(getContactInfo()));
});



'; ?>



//]]>
</script>


<?php endif; ?>