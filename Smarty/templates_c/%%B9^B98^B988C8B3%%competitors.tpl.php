<?php /* Smarty version 2.6.26, created on 2010-02-16 14:46:14
         compiled from eventviews/competitors.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'eventviews/competitors.tpl', 28, false),array('function', 'initializeGetFormFields', 'eventviews/competitors.tpl', 29, false),array('function', 'translate', 'eventviews/competitors.tpl', 31, false),array('function', 'sortheading', 'eventviews/competitors.tpl', 41, false),array('modifier', 'escape', 'eventviews/competitors.tpl', 32, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%B9^B98^B988C8B3%%competitors.tpl.inc'] = '188cdf50c9dbc3d37465d06b3169981c'; ?> <?php if ($this->_tpl_vars['mode'] == 'body'): ?>
<div id="event_content">
    <?php echo $this->_tpl_vars['page']->formattedText; ?>

</div>


<form method="get" class="usersform" action="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#0}'; endif;echo url_smarty(array('page' => 'event','view' => 'competitors','id' => $_GET['id']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#0}'; endif;?>
">
    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#1}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#1}'; endif;?>

    <div class="formelements">        
         <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#2}'; endif;echo translate_smarty(array('id' => 'users_searchhint'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#2}'; endif;?>
 </p>
        <input id="searchField" type="text" size="30" name="search" value="<?php echo ((is_array($_tmp=$_GET['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#3}'; endif;echo translate_smarty(array('id' => 'users_search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#3}'; endif;?>
" />
    </div>    
</form>
<hr style="clear: both;" />
<div class="SearchStatus" />

<table class="narrow" style="min-width: 400px">
   <tr>
    <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#4}'; endif;echo sortheading_smarty(array('field' => 'LastName','id' => 'lastname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#4}'; endif;?>
</th>
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#5}'; endif;echo sortheading_smarty(array('field' => 'FirstName','id' => 'firstname','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#5}'; endif;?>
</th>
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#6}'; endif;echo sortheading_smarty(array('field' => 'ClassName','id' => 'class','sortType' => 'alphabetical'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#6}'; endif;?>
</th>
      
      <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#7}'; endif;echo sortheading_smarty(array('field' => 'pdga','id' => 'users_pdga','sortType' => 'integer'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#7}'; endif;?>
</th>      
      
   </tr>

   <?php $_from = $this->_tpl_vars['participants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['participant']):
?>
            
      
     <tr>
        
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#8}'; endif;echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['participant']['user']->username), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#8}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['participant']['user']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
        <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#9}'; endif;echo url_smarty(array('page' => 'user','id' => $this->_tpl_vars['participant']['user']->username), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#9}'; endif;?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['participant']['user']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['participant']['className'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
         <td><?php echo ((is_array($_tmp=$this->_tpl_vars['participant']['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>         
         
     </tr>
   <?php endforeach; endif; unset($_from); ?>     
</table>

<div class="SearchStatus" />

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    TableSearch(document.getElementById(\'searchField\'), document.getElementById(\'userTable\'),
                '; ?>
"<?php if ($this->caching && !$this->_cache_including): echo '{nocache:188cdf50c9dbc3d37465d06b3169981c#10}'; endif;echo translate_smarty(array('id' => 'No_Search_Results'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:188cdf50c9dbc3d37465d06b3169981c#10}'; endif;?>
"<?php echo '
                );   
    $($(".SortHeading").get(0)).click();
    
});



'; ?>



//]]>
</script>

<?php endif; ?>