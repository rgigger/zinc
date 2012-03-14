<?php
function smarty_function_input($params, &$smarty)
{
	$type = isset($params['type']) ? $params['type'] : 'text';
	$valueAtt = isset($params['value']) ? $params['value'] : '';
	
	// handle the data bindings
	if(isset($params['data_object']))
	{
		if(!isset($params['data_field']))
			trigger_error("gui:input: if you specifiy a data object you must also specify a data field");
		
		$object = $params['data_object'];
		$field = $params['data_field'];
		if(!isset($params['append']) || $params['append'] == false)
		{
			$form = $smarty->getTemplateVars('__zinc');
			if(!$form)
				trigger_error("gui:input: if you specifiy a data object you must first use the 'openform' tag");
			$name = $form->addBinding($object, $field);
		}
		else
		{
			$binding = new FormBinding($object, $field);
			Form::appendBindings(array($binding));
			$name = $binding->getName();
		}
		if(isset($params['default']) && ($object->$field === '' || $object->$field === NULL))
			$value = $params['default'];
		else
			$value = isset($params['value']) ? $params['value'] : $object->$field;
		$namePart = ' name="' . $name . '"';
		if($type == 'radio')
			$valuePart = ' value="' . $valueAtt . '"';
		else
			$valuePart = ' value="' . $value . '"';
	}
	else
	{
		$value = $valueAtt;
		$name = isset($params['name']) ? $params['name'] : '';
		$namePart = isset($params['name']) ? ' name="' . $params['name'] . '"' : '';
		$valuePart = isset($params['value']) ? ' value="' . $params['value'] . '"' : '';
	}
	
	// pass on anything else they put in
	$extraFields = '';
	$extraMap = array();
	foreach($params as $paramName => $paramValue)
	{
		// if($paramName == 'name' && !isset($params['id']))
		// 	$params['id'] = $paramValue;
		
		if(in_array($paramName, array('type', 'name', 'type', 'value', 'default', 'data_object', 'data_field', 'append')))
			continue;
		
		if(substr($paramName, 0, 5) == 'data_')
			$paramName[4] = '-';
		
		$extraMap[$paramName] = $paramValue;
		$extraFields .= ' ' . $paramName . '="' . $paramValue . '"';
	}
		
	$required = isset($params['required']) && $params['required'];
	if($required)
		$extraFields .= ' data-constraint="required"';
	
	if(isset($params['sameas']))
		$extraFields .= ' data-constraint="sameas" data-sameas="' . $params['sameas'] . '"';
	
	switch($type)
	{
		case 'text':
		case 'submit':
		case 'hidden':
			return '<input type="' . $type . '"' . " $namePart $valuePart $extraFields>";
			break;
		case 'button':
			if(isset($params['href']))
				return '<a href="' . $params['href'] . "\" $extraFields>" . (isset($params['text']) ? $params['text'] : '') . "</a>";
			else
				return "<button $namePart $valuePart $extraFields>" . (isset($params['text']) ? $params['text'] : '') . "</button>";
			break;
		case 'checkbox':
			$checked = $value == 't' ? ' checked' : '';
			$return = '<input value="f" type="hidden"' . " $namePart $extraFields $checked>";
			$return .= '<input value="t" type="' . $type . '"' . " $namePart $extraFields $checked>";
			return $return;
			break;
		case 'password':
			return '<input type="' . $type . '"' . " $namePart $extraFields>";
			break;
		case 'radio':
			$checked = $valueAtt == $value ? ' checked' : '';
			return '<input type="' . $type . '"' . " $namePart $valuePart $extraFields $checked>";
			break;
		case 'textarea':			
			$return = '<textarea ' . $namePart . ' ' . $extraFields . '>';
			$return .= $value;
			$return .= '</textarea>';
			return $return;
			break;
		case 'select':
			require_once(SMARTY_PLUGINS_DIR . 'function.html_options.php');
			$selectParams = $extraMap;
			$selectParams['name'] = $name;
			$selectParams['selected'] = $value;
			$nameField = 'name';
			if(isset($extraMap['option_table']) && $extraMap['option_table'])
			{
				$tableName = $extraMap['option_table'];
				$selectParams['options'] = SqlFetchSimpleMap("SELECT id, :nameField AS name FROM :tableName:identifier order by id", 'id', 'name', 
												array('nameField:identifier' => $nameField, 'tableName' => $tableName));
			}
			else if($extraMap['options'])
				$selectParams['options'] = $extraMap['options'];
			
			return smarty_function_html_options($selectParams, $smarty);
			break;
		default:
			trigger_error("unknown input type: $type");
			break;
	}
}
