<?php /* Smarty version 2.6.26, created on 2010-02-18 19:57:22
         compiled from addcompetitor.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'addcompetitor.tpl', 22, false),array('function', 'initializeGetFormFields', 'addcompetitor.tpl', 33, false),array('function', 'url', 'addcompetitor.tpl', 40, false),array('function', 'formerror', 'addcompetitor.tpl', 104, false),array('function', 'html_select_date', 'addcompetitor.tpl', 148, false),array('function', 'html_options', 'addcompetitor.tpl', 164, false),array('modifier', 'escape', 'addcompetitor.tpl', 70, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%C6^C6E^C6E2469D%%addcompetitor.tpl.inc'] = '7b4f5c8a65e009087971d23a83b213c3'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#0}'; endif;echo translate_smarty(array('id' => 'addcompetitor_title','assign' => 'title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array('autocomplete' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "support/eventlockhelper.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['errorString']): ?><p class="error"><?php echo $this->_tpl_vars['errorString']; ?>
</p><?php endif; ?>

<?php if (! $this->_tpl_vars['userdata'] && ! is_array ( $this->_tpl_vars['many'] )): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#1}'; endif;echo translate_smarty(array('id' => 'add_competitor_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#1}'; endif;?>
</p>
    <form method="get">
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#2}'; endif;echo initializeGetFormFields_Smarty(array('search' => false), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#2}'; endif;?>

        <label><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#3}'; endif;echo translate_smarty(array('id' => 'add_competitor_prompt'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#3}'; endif;?>
</label>
        <input id="player" type="text" size="40" name="player" />
        <input name="op_s"  type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#4}'; endif;echo translate_smarty(array('id' => 'search'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#4}'; endif;?>
" />
    </form>
    
    <p>
        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#5}'; endif;echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#5}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#6}'; endif;echo translate_smarty(array('id' => 'add_competitor_create_new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#6}'; endif;?>
</a>
    </p>
    
    <script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
   var options, a;
    // Initialize autocomplete
    options = { serviceUrl: baseUrl ,
                params: {path: \'autocomplete\', \'id\': \'players\' }};
    a = $(\'#player\').autocomplete(options);
    
    
});

'; ?>


//]]>
</script>
    
    
<?php elseif (is_array ( $this->_tpl_vars['many'] )): ?>
        <p><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#7}'; endif;echo translate_smarty(array('id' => 'add_competitor_list_help'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#7}'; endif;?>
</p>
    <table class="oddrows">
        <?php $_from = $this->_tpl_vars['many']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
            <?php $this->assign('player', $this->_tpl_vars['user']->getPlayer()); ?>
            <tr>
                <td><a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#8}'; endif;echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => $this->_tpl_vars['user']->id), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#8}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#9}'; endif;echo translate_smarty(array('id' => 'select'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#9}'; endif;?>
</a></td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']->fullname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                
                <td>
                    <?php if ($this->_tpl_vars['user']->username): ?>
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['user']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                    <?php else: ?>
                        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#10}'; endif;echo translate_smarty(array('id' => 'add_competitor_no_username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#10}'; endif;?>
                    
                    <?php endif; ?>
                    
                </td>
            </tr>
        
        <?php endforeach; else: ?>
            <tr><td><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#11}'; endif;echo translate_smarty(array('id' => 'add_competitor_nomatch'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#11}'; endif;?>
</td></tr>
        <?php endif; unset($_from); ?>
    </table>
    
    <p>
        <a href="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#12}'; endif;echo url_smarty(array('page' => 'addcompetitor','id' => $_GET['id'],'user' => 'new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#12}'; endif;?>
"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#13}'; endif;echo translate_smarty(array('id' => 'add_competitor_create_new'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#13}'; endif;?>
</a>
    </p>

<?php else: ?>
    <form method="post" class="evenform" id="regform">
    <?php $this->assign('player', $this->_tpl_vars['userdata']->getPlayer()); ?>
    <input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['user']->id; ?>
" />
    <input type="hidden" name="formid" value="add_competitor" />
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#14}'; endif;echo translate_smarty(array('id' => 'reg_contact_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#14}'; endif;?>
</h2>    
    
    <div>
        <label  for="lastname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#15}'; endif;echo translate_smarty(array('id' => 'last_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#15}'; endif;?>
</label>
        <input id="lastname" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> type="text" name="lastname" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->lastname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#16}'; endif;echo formerror_smarty(array('field' => 'lastname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#16}'; endif;?>

    </div>
    <div>
        <label for="firstname"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#17}'; endif;echo translate_smarty(array('id' => 'first_name'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#17}'; endif;?>
</label>
        <input type="text" id="firstname" name="firstname" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?>  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->firstname)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#18}'; endif;echo formerror_smarty(array('field' => 'firstname'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#18}'; endif;?>

    </div>
    <div>
        <label for="email"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#19}'; endif;echo translate_smarty(array('id' => 'reg_email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#19}'; endif;?>
</label>
        <input id="email" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> type="text" name="email"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->email)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#20}'; endif;echo formerror_smarty(array('field' => 'email'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#20}'; endif;?>

    </div>
    
    <?php if ($this->_tpl_vars['userdata']->id): ?>
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#21}'; endif;echo translate_smarty(array('id' => 'reg_user_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#21}'; endif;?>
</h2>
    <div>
        <label for="username"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#22}'; endif;echo translate_smarty(array('id' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#22}'; endif;?>
</label>
        <input id="username" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> type="text" name="username"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userdata']->username)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#23}'; endif;echo formerror_smarty(array('field' => 'username'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#23}'; endif;?>

    </div>
    <?php endif; ?>

    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#24}'; endif;echo translate_smarty(array('id' => 'reg_player_info'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#24}'; endif;?>
</h2>
     <div>
        <label for="pdga"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#25}'; endif;echo translate_smarty(array('id' => 'pdga_number'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#25}'; endif;?>
</label>
        <input id="pdga" type="text" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> name="pdga"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['player']->pdga)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#26}'; endif;echo formerror_smarty(array('field' => 'pdga'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#26}'; endif;?>

    </div>
     
     <div>
        <label for="gender"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#27}'; endif;echo translate_smarty(array('id' => 'gender'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#27}'; endif;?>
</label>
        <input id="gender" type="radio" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> <?php if ($this->_tpl_vars['player']->gender == 'M'): ?>checked="checked"<?php endif; ?> name="gender" value="male" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#28}'; endif;echo translate_smarty(array('id' => 'male'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#28}'; endif;?>
 &nbsp;&nbsp;
        <input type="radio" <?php if (! $this->_tpl_vars['edit']): ?>disabled="disabled"<?php endif; ?> <?php if ($this->_tpl_vars['player']->gender == 'F'): ?>checked="checked"<?php endif; ?> name="gender" value="female" /> <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#29}'; endif;echo translate_smarty(array('id' => 'female'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#29}'; endif;?>

        
    </div>
     
     
     <div style="margin-top: 8px">
        <label><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#30}'; endif;echo translate_smarty(array('id' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#30}'; endif;?>
</label>


        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#31}'; endif;echo translate_smarty(array('id' => 'year_default','assign' => 'year_default'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#31}'; endif;?>

        <?php if ($this->_tpl_vars['edit']): ?>
        <?php echo smarty_function_html_select_date(array('time' => "0-0-0",'field_order' => 'DMY','month_format' => "%m",'prefix' => 'dob_','start_year' => '1900','display_months' => false,'display_days' => false,'year_empty' => $this->_tpl_vars['year_default'],'month_empty' => $this->_tpl_vars['month_default'],'day_empty' => $this->_tpl_vars['day_default'],'field_separator' => ' ','all_extra' => 'style="min-width: 0"'), $this);?>

        <?php else: ?>
        <input type="text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['player']->birthyear)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" disabled="disabled" />
        <?php endif; ?>
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#32}'; endif;echo formerror_smarty(array('field' => 'dob'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#32}'; endif;?>

    </div>
     
     <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#33}'; endif;echo translate_smarty(array('id' => 'add_competitor_class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#33}'; endif;?>
</h2>
     <div>
        
        <label for="class"><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#34}'; endif;echo translate_smarty(array('id' => 'class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#34}'; endif;?>
</label>
        
        <select id="class" name="class">
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['classOptions']), $this);?>

        </select>
        
        <?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#35}'; endif;echo formerror_smarty(array('field' => 'class'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#35}'; endif;?>

     </div>
    
   
    
    <h2><?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#36}'; endif;echo translate_smarty(array('id' => 'reg_finalize'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#36}'; endif;?>
</h2>
    <div>
        <input type="submit" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#37}'; endif;echo translate_smarty(array('id' => 'form_accept'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#37}'; endif;?>
" name="accept" />
        <input type="submit" id="cancelButton" value="<?php if ($this->caching && !$this->_cache_including): echo '{nocache:7b4f5c8a65e009087971d23a83b213c3#38}'; endif;echo translate_smarty(array('id' => 'form_cancel'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:7b4f5c8a65e009087971d23a83b213c3#38}'; endif;?>
" name="cancel" />
        
        
    </div>
</form>

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(document).ready(function(){
    CheckedFormField(\'regform\', \'lastname\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'firstname\', NonEmptyField, null);
    CheckedFormField(\'regform\', \'email\', EmailField, null);    

    CheckedFormField(\'regform\', \'gender\', RadioFieldSet, null);
    CheckedFormField(\'regform\', \'dob_Year\', NonEmptyField, null);
    
    
    $("#cancelButton").click(CancelSubmit);
    
});

'; ?>



//]]>
</script>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>