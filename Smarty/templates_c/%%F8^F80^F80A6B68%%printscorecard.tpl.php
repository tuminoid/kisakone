<?php /* Smarty version 2.6.26, created on 2010-02-16 14:55:43
         compiled from printscorecard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'printscorecard.tpl', 27, false),array('function', 'math', 'printscorecard.tpl', 97, false),array('function', 'initializeGetFormFields', 'printscorecard.tpl', 106, false),array('function', 'counter', 'printscorecard.tpl', 119, false),array('modifier', 'escape', 'printscorecard.tpl', 113, false),array('modifier', 'date_format', 'printscorecard.tpl', 125, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%F8^F80^F80A6B68%%printscorecard.tpl.inc'] = 'c0cb67562d500d93bcb0322048a76f86'; ?><!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <title><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#0}'; endif;echo translate_smarty(array('id' => 'site_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#0}'; endif;?>
</title>
      <link rel="stylesheet" href="<?php echo $this->_tpl_vars['url_base']; ?>
ui/elements/style.css" type="text/css" />
      
 <style type="text/css"><?php echo '
 table {
   border-collapse: collapse;
 }
 html, body {
      padding: 4px;
 }
 
 td,th  {
   border: 1px solid black;
   text-align: center;
   padding: 3px;
 }
 
 .out, .in {
   background-color: #DDD;
 }
 
 #last_head_row th {
   border-bottom: 2px solid black;
 }
 
 .autowidth {
   width: auto !important;
 }
 
 
 .group {
      page-break-inside: avoid;
      
      margin-bottom: 80px;
 }
 
 .sign_row {
      text-align: right;
      padding-right: 300px;
 }
 
 .endofpage {
      page-break-after: always;
 }
 
 .noprint {
      background-color: #eee;
      padding: 16px;
      margin: 16px;
 }
 
 .sign {
      min-width: 160px;
 }
 '; ?>

 
 td {
   width: <?php echo $this->_tpl_vars['hole_percentage']; ?>
%;
   height: 2em;
 }
 </style>
 <style type="text/css" media="print">
 .noprint { display: none; }
 body {
      font-size: 0.8em;
      
       }
 </style>
</head>

 <?php echo smarty_function_math(array('assign' => 'hole_percentage','equation' => "75 / (x+4)",'x' => $this->_tpl_vars['numHoles']), $this);?>

 <?php $this->assign('perpage', $_GET['perpage']); ?>
 <?php if (! ( $this->_tpl_vars['perpage'] % 99 )): ?><?php $this->assign('perpage', 3); ?><?php endif; ?>
 
 
<body>
      <?php $this->assign('signature', $_GET['signature']); ?>
<div class="noprint">
      <form method="get">
            <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#1}'; endif;echo initializeGetFormFields_Smarty(array('signature' => false,'perpage' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#1}'; endif;?>

      <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#2}'; endif;echo translate_smarty(array('id' => 'scorecard_sign_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#2}'; endif;?>
</p>
      <ul class="nobullets">
            <li><input type="radio" name="signature" value="" <?php if ($this->_tpl_vars['signature'] == ''): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#3}'; endif;echo translate_smarty(array('id' => 'signature_none'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#3}'; endif;?>
</li>
            <li><input type="radio" name="signature" value="column" <?php if ($this->_tpl_vars['signature'] == 'column'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#4}'; endif;echo translate_smarty(array('id' => 'signature_column'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#4}'; endif;?>
</li>
            <li><input type="radio" name="signature" value="row" <?php if ($this->_tpl_vars['signature'] == 'row'): ?>checked="checked"<?php endif; ?> /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#5}'; endif;echo translate_smarty(array('id' => 'signature_row'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#5}'; endif;?>
</li>
      </ul>
      <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#6}'; endif;echo translate_smarty(array('id' => 'scorecard_perpage'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#6}'; endif;?>
 <input name="perpage"  type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['perpage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></p>
      <p><input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#7}'; endif;echo translate_smarty(array('id' => 'update'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#7}'; endif;?>
" /></p>
      </form>
</div>
      
<?php $_from = $this->_tpl_vars['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
<?php echo smarty_function_counter(array('assign' => 'groupcounter'), $this);?>

<div class="group <?php if ($this->_tpl_vars['groupcounter'] % $this->_tpl_vars['perpage'] == 0): ?> endofpage<?php endif; ?>">      
   <?php $this->assign('firstgroup', $this->_tpl_vars['group']['0']); ?>

   
   <h1><?php echo $this->_tpl_vars['event']->name; ?>
, <?php echo $this->_tpl_vars['event']->venue; ?>
 <?php echo $this->_tpl_vars['event']->fulldate; ?>
</h1>
   <h3><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#8}'; endif;echo translate_smarty(array('id' => 'round_number','number' => $this->_tpl_vars['round']->roundNumber), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#8}'; endif;?>
, <?php echo ((is_array($_tmp=$this->_tpl_vars['round']->starttime)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y") : smarty_modifier_date_format($_tmp, "%d.%m.%Y")); ?>
</h3>
   <h3><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#9}'; endif;echo translate_smarty(array('id' => 'group_number','number' => $this->_tpl_vars['firstgroup']['PoolNumber']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#9}'; endif;?>
,   
   <?php if ($this->_tpl_vars['round']->starttype == 'sequential'): ?>
   <?php ob_start(); ?><?php echo ((is_array($_tmp=$this->_tpl_vars['firstgroup']['StartingTime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('groupstart', ob_get_contents());ob_end_clean(); ?>
   <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#10}'; endif;echo translate_smarty(array('id' => 'group_starting','start' => $this->_tpl_vars['groupstart']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#10}'; endif;?>

   <?php else: ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#11}'; endif;echo translate_smarty(array('id' => 'your_group_starting_hole','hole' => $this->_tpl_vars['firstgroup']['StartingHole']), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#11}'; endif;?>
<?php endif; ?>
   </h3>
      
    <table>
         
            <tr class="thr">
                <th class="rightside" colspan="2">
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#12}'; endif;echo translate_smarty(array('id' => 'hole_num'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#12}'; endif;?>

                </th>
                <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>                
                        <th><?php echo $this->_tpl_vars['hole']->holeNumber; ?>
</th>
                        <?php if ($this->_tpl_vars['hole']->holeNumber == $this->_tpl_vars['out_hole_index']): ?>
                           <th class="out"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#13}'; endif;echo translate_smarty(array('id' => 'hole_out'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#13}'; endif;?>
</th>
                        <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <th class="in"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#14}'; endif;echo translate_smarty(array('id' => 'hole_in'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#14}'; endif;?>
</th>
                <th>+/-</th>
                <th><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#15}'; endif;echo translate_smarty(array('id' => 'total'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#15}'; endif;?>
</th>
                <?php if ($this->_tpl_vars['signature'] == 'column'): ?>
                <th rowspan="3" class="sign"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#16}'; endif;echo translate_smarty(array('id' => 'signature'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#16}'; endif;?>
</th>
                <?php endif; ?>
            </tr>
            <tr class="thr">
                <th class="rightside" colspan="2">
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#17}'; endif;echo translate_smarty(array('id' => 'hole_par'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#17}'; endif;?>

                </th>
                <?php $this->assign('combined', 0); ?>
                <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>                
                        <th><?php echo $this->_tpl_vars['hole']->par; ?>
</th>
                        <?php echo smarty_function_math(array('assign' => 'combined','equation' => "x+y",'x' => $this->_tpl_vars['combined'],'y' => $this->_tpl_vars['hole']->par), $this);?>

                        <?php if ($this->_tpl_vars['hole']->holeNumber == $this->_tpl_vars['out_hole_index']): ?>
                           <?php $this->assign('out', $this->_tpl_vars['combined']); ?>
                           <th class="out"><?php echo $this->_tpl_vars['combined']; ?>
</th>
                        <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                
                <th class="in"><?php echo smarty_function_math(array('equation' => "x-y",'x' => $this->_tpl_vars['combined'],'y' => $this->_tpl_vars['out']), $this);?>
</th>
                <th><?php echo $this->_tpl_vars['combined']; ?>
</th>
                <th><?php echo $this->_tpl_vars['combined']; ?>
</th>
            </tr>
            
            <tr class="thr" id="last_head_row">
                <th class="rightside" colspan="2">
                    <?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#18}'; endif;echo translate_smarty(array('id' => 'hole_length'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#18}'; endif;?>

                </th>
                <?php $this->assign('combined', 0); ?>
                <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>                
                        <th><?php echo $this->_tpl_vars['hole']->length; ?>
</th>
                        <?php echo smarty_function_math(array('assign' => 'combined','equation' => "x+y",'x' => $this->_tpl_vars['combined'],'y' => $this->_tpl_vars['hole']->length), $this);?>

                        <?php if ($this->_tpl_vars['hole']->holeNumber == $this->_tpl_vars['out_hole_index']): ?>
                           <?php $this->assign('out', $this->_tpl_vars['combined']); ?>
                           <th class="out"><?php echo $this->_tpl_vars['combined']; ?>
</th>
                        <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>            
                
                <th class="in"><?php echo smarty_function_math(array('equation' => "x-y",'x' => $this->_tpl_vars['combined'],'y' => $this->_tpl_vars['out']), $this);?>
</th>
                <th></th>
                <th><?php echo $this->_tpl_vars['combined']; ?>
</th>
                
            </tr>
            
            
            <?php $_from = $this->_tpl_vars['group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['player']):
?>
            <tr>
                
                <td class="autowidth" <?php if ($this->_tpl_vars['signature'] == 'row'): ?> rowspan="2"<?php endif; ?>><?php echo smarty_function_math(array('equation' => "x+1",'x' => $this->_tpl_vars['index']), $this);?>
</td>
                <td class="autowidth" <?php if ($this->_tpl_vars['signature'] == 'row'): ?> rowspan="2"<?php endif; ?>>
                    <?php echo $this->_tpl_vars['player']['FirstName']; ?>
 <?php echo $this->_tpl_vars['player']['LastName']; ?>

                </td>
                <?php $_from = $this->_tpl_vars['holes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['hole']):
?>                
                        <td></td>                        
                <?php endforeach; endif; unset($_from); ?>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?php if ($this->_tpl_vars['signature'] == 'column'): ?>
                        <td></td>
                  <?php endif; ?> 
                
            </tr>
            <?php if ($this->_tpl_vars['signature'] == 'row'): ?>
            <tr>
                  <td colspan="<?php echo smarty_function_math(array('equation' => "x +4 ",'x' => $this->_tpl_vars['numHoles']), $this);?>
" class="sign_row"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:c0cb67562d500d93bcb0322048a76f86#19}'; endif;echo translate_smarty(array('id' => 'signature'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:c0cb67562d500d93bcb0322048a76f86#19}'; endif;?>
:</td>
       
            </tr>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        
    </table>
</div>
<?php endforeach; endif; unset($_from); ?>
</body>
</html>