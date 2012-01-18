<?php
function smarty_function_closeform($params, &$smarty)
{
	$form = $smarty->getTemplateVars('__zinc');
	
	if($form)
	{
		$form->saveBindings();
		list($name, $value) = $form->getTagInfo();
		return '<input type="hidden" name="' . $name . '" value="' . $value . '"></form>';
	}
}
