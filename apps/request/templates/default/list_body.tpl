{foreach from=$requests item=thisRequest}
	<tr>
		<td>{$thisRequest->id}</td>
		<td><a href="{$zoneUrl}/view/{$thisRequest->id}">{$thisRequest->name}</a></td>
		<td>{$thisRequest->short_desc|nl2br}</td>
		<td>{$thisRequest->priority}</td>
		<td>{$thisRequest->Creator->getName()}</td>
		<td>{$thisRequest->status}</td>
	</tr>
{/foreach}
