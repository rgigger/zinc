<?php
function smarty_function_init($params, &$smarty)
{
	$modules = isset($params['type']) ? array($params['type']) : array('dnd', 'ajax', 'input');
	foreach($modules as $thisModule)
	{
		GuiInit::$thisModule();
	}
}

class GuiInit
{
	function dnd()
	{
		
	}
	
	function ajax()
	{
		
	}
	
	function input()
	{
?>
<script>
(function($){
	$.fn.validate = function( options ) {  

    // Create some defaults, extending them with any options that were provided
    // var settings = $.extend( {
    //   'location'         : 'top',
    //   'background-color' : 'blue'
    // }, options);

		return this.each(function() {        
			var form = $(this);
			
			form.submit(function() {
				var ok = true;
				var messages = [];
				$('.constraint').each(function() {
					var constraintElement = $(this);
					var res = GuiCheckConstraint(constraintElement);
					
					console.log(res);
					if(!res['ok'])
					{
						ok = false;
						messages.push(res['message']);
					}
				});
				
				if(!ok)
				{
					var messageText = messages.join('<br>');
					var status = $('#gui_status');
					status.html(messageText);					
					return false;
				}
				
				return true;
			});
			
		});
	};
})( jQuery );

function GuiCheckConstraint(constraint)
{
	var res = {ok: true, message: ''};
	console.log(constraint.attr('name'));
	console.log(constraint.attr('data-constraint'));
	switch(constraint.attr('data-constraint'))
	{
		case 'minlen':
			if(constraint.val().length < constraint.attr('data-minlen'))
			{
				res['ok'] = false;
				res['message'] = constraint.attr('data-message');
			}
			break;
		case 'intrange':
			var value = parseInt(constraint.val());
			if(value < constraint.attr('data-range-min') || value > constraint.attr('data-range-max'))
			{
				res['ok'] = false;
				res['message'] = constraint.attr('data-message');
			}
			break;
		case 'required':
			if(constraint.val().length < 1)
			{
				res['ok'] = false;
				res['message'] = constraint.attr('data-message');
			}
			break;
		case 'requireOther':
			if(constraint.val() == constraint.attr('data-other-value') && $('#' + constraint.attr('data-other-field')).val().trim().length == 0)
			{
				console.log('failed');
				res['ok'] = false;
				res['message'] = constraint.attr('data-message');
				console.log(res['message']);
			}
			else
				console.log('didnt fail');
			break;
		// case 'sameas':
		// 	var input = document.getElementById(constraint.name);
		// 	var input2 = document.getElementById(constraint.value);
		// 	if(input.value != input2.value)
		// 	{
		// 		res['ok'] = false;
		// 		res['message'] = constraint.inline;
		// 	}
		// 	break;
		default:
			console.log(constraint);
			throw "Bad constraint type: " + constraint.attr('data-constraint');
			break;
	}
	return res;
}

</script>
<?php
	}
}