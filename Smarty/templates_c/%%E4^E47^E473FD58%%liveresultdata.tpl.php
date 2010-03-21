<?php /* Smarty version 2.6.26, created on 2010-02-17 19:14:11
         compiled from liveresultdata.tpl */ ?>
{
    "status": "<?php echo $this->_tpl_vars['statusText']; ?>
",
    "updatedAt": <?php echo $this->_tpl_vars['updateTime']; ?>
,
    "forceRefresh" : <?php echo $this->_tpl_vars['forceRefresh']; ?>
,
    "updates" : {
    <?php $this->assign('first', true); ?>
        <?php $_from = $this->_tpl_vars['updates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind'] => $this->_tpl_vars['update']):
?>
        <?php if (! $this->_tpl_vars['first']): ?>,<?php endif; ?>
        <?php $this->assign('first', false); ?>
        <?php echo $this->_tpl_vars['ind']; ?>
: {
            "pid": <?php echo $this->_tpl_vars['update']['PlayerId']; ?>
,
            "hole": <?php if ($this->_tpl_vars['update']['HoleId']): ?><?php echo $this->_tpl_vars['update']['HoleId']; ?>
<?php elseif ($this->_tpl_vars['update']['Special'] == 'Penalty'): ?>"p"<?php else: ?>"sd"<?php endif; ?>,
            "value": <?php echo $this->_tpl_vars['update']['Value']; ?>
,
            "round": <?php echo $this->_tpl_vars['update']['RoundId']; ?>
,
            "holeNum": <?php echo $this->_tpl_vars['update']['HoleNum']; ?>

        }
        <?php endforeach; endif; unset($_from); ?>
        
    
    }

}