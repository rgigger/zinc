{foreach from=$requests item=thisRequest}
	<tr>
		<td>{$thisRequest->id}</td>
		<td><a href="{$zoneUrl}/view/{$thisRequest->id}">{$thisRequest->name}</a></td>
		<td>{$thisRequest->short_desc|nl2br}</td>
		<td>{$thisRequest->priority}</td>
		<td>{$thisRequest->Person->getName()}</td>
		<td id="completed_{$thisRequest->id}">{if $thisRequest->completed == 't'}yes{else}no{/if}</td>
	</tr>
{/foreach}
