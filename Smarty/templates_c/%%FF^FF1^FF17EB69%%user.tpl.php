<?php /* Smarty version 2.6.26, created on 2010-02-16 14:27:34
         compiled from user.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'user.tpl', 22, false),array('modifier', 'escape', 'user.tpl', 25, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%FF^FF1^FF17EB69%%user.tpl.inc'] = '748f8faf554e2864a4b65a6e8f5dcdcb'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#0}'; endif;echo translate_smarty(array('id' => 'users_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h3><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#1}'; endif;echo translate_smarty(array('id' => 'user_header','user' => ((is_array($_tmp=$this->_tpl_vars['userinfo']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#1}'; endif;?>
</h3>

<hr />

<table style="width:300px">
   <tr>
      <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#2}'; endif;echo translate_smarty(array('id' => 'user_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#2}'; endif;?>
: </td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']->fullname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
   </tr>
   <?php if ($this->_tpl_vars['player']): ?>
      <tr>
         <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#3}'; endif;echo translate_smarty(array('id' => 'user_gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#3}'; endif;?>
: </td>
         <td><?php ob_start(); ?>gender_<?php echo $this->_tpl_vars['player']->gender; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('gendertoken', ob_get_contents());ob_end_clean(); ?>
         <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#4}'; endif;echo translate_smarty(array('id' => $this->_tpl_vars['gendertoken']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#4}'; endif;?>
</td>
      </tr>
      <tr>
         <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#5}'; endif;echo translate_smarty(array('id' => 'user_yearofbirth'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#5}'; endif;?>
: </td>
         <td><?php echo ((is_array($_tmp=$this->_tpl_vars['player']->birthyear)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
      </tr>
      <tr>
         <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#6}'; endif;echo translate_smarty(array('id' => 'user_pdga_number'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#6}'; endif;?>
: </td>
         <td><?php echo ((is_array($_tmp=$this->_tpl_vars['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
      </tr>
      <?php else: ?>
         <tr><td colspan="2">
         <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#7}'; endif;echo translate_smarty(array('id' => 'user_not_player'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#7}'; endif;?>

         </td></tr>
      <?php endif; ?>
</table>

<?php if ($this->_tpl_vars['player'] && $this->_tpl_vars['player']->pdga): ?>
<p><a href="http://www.pdga.com/player-stats?PDGANum=<?php echo $this->_tpl_vars['player']->pdga; ?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#8}'; endif;echo translate_smarty(array('id' => 'user_pdga_link'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#8}'; endif;?>
</a></p>
<?php endif; ?>

<?php if (( $this->_tpl_vars['itsme'] || $this->_tpl_vars['isadmin'] ) && $this->_tpl_vars['player']): ?>
   <hr />
      <table style="width:300px">
         <?php if ($this->_tpl_vars['fees']): ?>
            <tr>
               <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#9}'; endif;echo translate_smarty(array('id' => 'user_membershipfee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#9}'; endif;?>
: </td>
               <td>
                  <?php $_from = $this->_tpl_vars['fees']['membership']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['paid']):
?>
                     <?php if ($this->_tpl_vars['paid']): ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#10}'; endif;echo translate_smarty(array('id' => 'user_ispaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#10}'; endif;?>

                     <?php else: ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#11}'; endif;echo translate_smarty(array('id' => 'user_notpaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#11}'; endif;?>
               
                     <?php endif; ?>
                     <br />
                  <?php endforeach; endif; unset($_from); ?>
               </td>
            </tr>
            <tr>
               <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#12}'; endif;echo translate_smarty(array('id' => 'user_licensefee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#12}'; endif;?>
: </td>
               <td>
                  <?php $_from = $this->_tpl_vars['fees']['license']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['paid']):
?>
                     <?php if ($this->_tpl_vars['paid']): ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#13}'; endif;echo translate_smarty(array('id' => 'user_ispaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#13}'; endif;?>

                     <?php else: ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#14}'; endif;echo translate_smarty(array('id' => 'user_notpaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#14}'; endif;?>
               
                     <?php endif; ?>
                     <br />
                  <?php endforeach; endif; unset($_from); ?>
     
               </td>
            </tr>
         <?php else: ?>
            <tr>
               <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#15}'; endif;echo translate_smarty(array('id' => 'user_membershipfee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#15}'; endif;?>
: </td>
               <td>
                  <?php $_from = $this->_tpl_vars['player']->membershipfeespaid(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['paid']):
?>
                     <?php if ($this->_tpl_vars['paid']): ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#16}'; endif;echo translate_smarty(array('id' => 'user_ispaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#16}'; endif;?>

                     <?php else: ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#17}'; endif;echo translate_smarty(array('id' => 'user_notpaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#17}'; endif;?>
               
                     <?php endif; ?>
                     <br />
                  <?php endforeach; endif; unset($_from); ?>
               </td>
            </tr>
            <tr>
               <td ><?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#18}'; endif;echo translate_smarty(array('id' => 'user_licensefee'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#18}'; endif;?>
: </td>
               <td>
                  <?php $_from = $this->_tpl_vars['player']->licensefeespaid(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['year'] => $this->_tpl_vars['paid']):
?>
                     <?php if ($this->_tpl_vars['paid']): ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#19}'; endif;echo translate_smarty(array('id' => 'user_ispaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#19}'; endif;?>

                     <?php else: ?>
                        <?php echo $this->_tpl_vars['year']; ?>
 <?php if ($this->caching && !$this->_cache_including): echo '{nocache:748f8faf554e2864a4b65a6e8f5dcdcb#20}'; endif;echo translate_smarty(array('id' => 'user_notpaid'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:748f8faf554e2864a4b65a6e8f5dcdcb#20}'; endif;?>
               
                     <?php endif; ?>
                     <br />
                  <?php endforeach; endif; unset($_from); ?>
     
               </td>
            </tr>
         <?php endif; ?>

      </table>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>