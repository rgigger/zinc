<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:3:{s:10:"F384501455";a:2:{i:0;s:21:"./templates/index.tpl";i:1;i:1257977415;}s:11:"F1129582534";a:2:{i:0;s:22:"./templates/header.tpl";i:1;i:1257977415;}s:11:"F1159251177";a:2:{i:0;s:22:"./templates/footer.tpl";i:1;i:1257977415;}}}'); ?>
<?php /* Smarty version Smarty3-SVN$Rev: 3286 $, created on 2009-11-12 11:53:15
         compiled from "./templates/index.tpl" */ ?>
<?php  $_config = new Smarty_Internal_Config("test.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", $_smarty_tpl->smarty);  $_template = new Smarty_Template ("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->assign('title','foo');$_template->caching = 1; $_tpl_stack[] = $_smarty_tpl; $_smarty_tpl = $_template; /* Smarty version Smarty3-SVN$Rev: 3286 $, created on 2009-11-12 11:53:15
         compiled from "./templates/header.tpl" */ ?>
<HTML>
<HEAD>
<?php echo $_smarty_tpl->smarty->plugin_handler->popup_init(array(array('src'=>"/javascripts/overlib.js"),$_smarty_tpl->smarty,$_smarty_tpl),'function');?>
<TITLE><?php echo $_smarty_tpl->getVariable('title')->value;?>
 - <?php  echo '<?php echo $_smarty_tpl->getVariable(\'Name\')->value;?>
';?></TITLE>
</HEAD>
<BODY bgcolor="#ffffff">
<?php /*  End of included template "./templates/header.tpl" */   $_smarty_tpl = array_pop($_tpl_stack); unset($_template); ?>

<PRE>


<?php if ($_smarty_tpl->getConfigVariable('bold')){?><b><?php }?>

Title: <?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('capitalize',array($_smarty_tpl->getConfigVariable('title')),true);?>

<?php if ($_smarty_tpl->getConfigVariable('bold')){?></b><?php }?>

The current date and time is <?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier('date_format',array(time(),"%Y-%m-%d %H:%M:%S"),true);?>


The value of global assigned variable $SCRIPT_NAME is <?php echo $_smarty_tpl->getVariable('SCRIPT_NAME')->value;?>


Example of accessing server environment variable SERVER_NAME: <?php echo $_SERVER['SERVER_NAME'];?>


The value of {$Name} is <b><?php  echo '<?php echo $_smarty_tpl->getVariable(\'Name\')->value;?>
';?></b>

variable modifier example of {$Name|upper}

<b><?php  echo '<?php echo $_smarty_tpl->smarty->plugin_handler->executeModifier(\'upper\',array($_smarty_tpl->getVariable(\'Name\')->value),true);?>
';?></b>


An example of a section loop:

<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['name'] = 'outer';
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('FirstName')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['outer']['total']);
 if ((1 & $_smarty_tpl->getVariable('smarty')->value['section']['outer']['index'] / 2)){?>
	<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['outer']['rownum'];?>
 . <?php echo $_smarty_tpl->getVariable('FirstName')->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']];?>
 <?php echo $_smarty_tpl->getVariable('LastName')->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']];?>

<?php }else{ ?>
	<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['outer']['rownum'];?>
 * <?php echo $_smarty_tpl->getVariable('FirstName')->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']];?>
 <?php echo $_smarty_tpl->getVariable('LastName')->value[$_smarty_tpl->getVariable('smarty')->value['section']['outer']['index']];?>

<?php } endfor; else: ?>
	none
<?php endif; ?>

An example of section looped key values:

<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['name'] = 'sec1';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('contacts')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sec1']['total']);
?>
	phone: <?php echo $_smarty_tpl->getVariable('contacts')->value[$_smarty_tpl->getVariable('smarty')->value['section']['sec1']['index']]['phone'];?>
<br>
	fax: <?php echo $_smarty_tpl->getVariable('contacts')->value[$_smarty_tpl->getVariable('smarty')->value['section']['sec1']['index']]['fax'];?>
<br>
	cell: <?php echo $_smarty_tpl->getVariable('contacts')->value[$_smarty_tpl->getVariable('smarty')->value['section']['sec1']['index']]['cell'];?>
<br>
<?php endfor; endif; ?>
<p>

testing strip tags
<?php ob_start(); ?>
<table border=0>
	<tr>
		<td>
			<A HREF="<?php echo $_smarty_tpl->getVariable('SCRIPT_NAME')->value;?>
">
			<font color="red">This is a  test     </font>
			</A>
		</td>
	</tr>
</table>
<?php echo preg_replace('![	 ]*[
]+[	 ]*!', '', ob_get_clean()); ?>


</PRE>

This is an example of the html_select_date function:

<form>
<?php echo $_smarty_tpl->smarty->plugin_handler->html_select_date(array(array('start_year'=>1998,'end_year'=>2010),$_smarty_tpl->smarty,$_smarty_tpl),'function');?>
</form>

This is an example of the html_select_time function:

<form>
<?php echo $_smarty_tpl->smarty->plugin_handler->html_select_time(array(array('use_24_hours'=>false),$_smarty_tpl->smarty,$_smarty_tpl),'function');?>
</form>

This is an example of the html_options function:

<form>
<select name=states>
<?php echo $_smarty_tpl->smarty->plugin_handler->html_options(array(array('values'=>$_smarty_tpl->getVariable('option_values')->value,'selected'=>$_smarty_tpl->getVariable('option_selected')->value,'output'=>$_smarty_tpl->getVariable('option_output')->value),$_smarty_tpl->smarty,$_smarty_tpl),'function');?>
</select>
</form>

<?php $_template = new Smarty_Template ("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id,  $_smarty_tpl->compile_id);$_template->caching = 1; $_tpl_stack[] = $_smarty_tpl; $_smarty_tpl = $_template; /* Smarty version Smarty3-SVN$Rev: 3286 $, created on 2009-11-12 11:53:15
         compiled from "./templates/footer.tpl" */ ?>
</BODY>
</HTML>
<?php /*  End of included template "./templates/footer.tpl" */   $_smarty_tpl = array_pop($_tpl_stack); unset($_template); ?>
