<div id="filterChoose">
	Current Filter: {html_options id="currentFilter" selected=$filterId name="currentFilter" options=$filterList}
</div>

<hr>

<div id="filterbox">
	{include file="filter/edit_body.tpl"}
	<button id="apply" type="button">Apply</button>
	<button id="save" type="button">Save</button>
</div>
<br>
<div><a href="#" onclick="$('#filterbox').toggle(); return false;">show/hide filter</a></div>


<script type="text/javascript">

var filterId = '{$filterId}';
var content = {if $filter->content}{$filter->content}{else}null{/if};

{literal}
$(document).ready(function() {
	$('#apply').click(function() {
		$('#list_table tbody').empty();
		var getVars = {filterData: getFilterData()};
		$.get(zoneUrl + '/listBody', getVars, function(html) {
			$("#list_table tbody").append(html); 
			$("#list_table tbody").trigger("update"); 
			var sorting = [[3,1],[1,0]]; 
			$("#list_table tbody").trigger("sorton", [sorting]); 
		});
		return false;
	});
	
	$('#save').click(function() {
		if(filterId)
		{
			var postData = {
				id: filterId,
				content: getFilterData()
			}
			$.post(zoneUrl + '/saveFilter', postData, function(res) {
				alert(res.id);
			}, 'json');			
		}
		else
			$('#dialog').dialog('open');
	});
	
	$('#currentFilter').change(function() {
		document.location = zoneUrl + '/list/' + $('#currentFilter').val();
	});
	
	$.tablesorter.addParser({
		id: 'priority',
		is: function(s) {
			return false;
		},
		format: function(s) {
			if(s == 'Low')
				return 1;
			else if(s == 'Medium')
				return 2;
			else if(s == 'High')
				return 3;
			else
				return 0;
			// return s.toLowerCase().replace(/low/,1).replace(/medium/,2).replace(/high/,3);
		},
		type: 'numeric'
	});
	
	$("#list_table").tablesorter({
		widgets: ['zebra'],
		headers: {
			3: {sorter: 'priority'}
		}
	});
	
	
	$("#dialog").dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			'Save': function() {
				var newFilterName = $('#newFilterName').val();
				var postData = {
					id: filterId,
					name: newFilterName,
					content: getFilterData()
				}
				$.post(zoneUrl + '/saveFilter', postData, function(res) {
					if(!filterId && res.id)
						document.location = zoneUrl + '/list/' + res.id
				}, 'json');
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {
		}
	});
	
	// $("table").tablesorter();
	// $("#ajax-append").click(function()
	// {
	// 	 $.get("assets/ajax-content.html", function(html)
	// 	{
	// 		 // append the "ajax'd" data to the table body
	// 		 $("table tbody").append(html);
	// 		// let the plugin know that we made a update
	// 		$("table").trigger("update");
	// 		// set sorting column and direction, this will sort on the first and third column
	// 		var sorting = [[2,1],[0,0]];
	// 		// sort on the first column
	// 		$("table").trigger("sorton",[sorting]);
	// 	});
	// 	return false;
	// });
});



{/literal}

</script>

<div id="main">
  	<table id="list_table" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
	<thead>
	<tr>
		<th width="25">id</th>
		<th>name</th>
		<th>desc</th>
		<th width="60">priority</th>
		<th width="60">owner</th>
		<th width="80">completed</th>
	</tr>
	</thead>
	<tbody>
		{include file="default/list_body.tpl"}
	</tbody>
</table>
<input id="add" type="button" value="add" onclick="document.location = '{$scriptUrl}/edit'" ACCESSKEY="a">


<div id="dialog" title="Save Filter">
	<p>Please choose a name for this filter.</p>
	<form>
		<label for="name">Name:</label>
		<input type="text" name="name" id="newFilterName" class="text ui-widget-content ui-corner-all" />
	</form>
</div>

</div>
{literal}
{/literal}