{foreach from=$requests item=thisRequest}
	<tr>
		<td>{$thisRequest->id}</td>
		<td><a href="{$zoneUrl}/edit/{$thisRequest->id}">{$thisRequest->name}</a></td>
		<td>{$thisRequest->description}</td>
		<td>{$thisRequest->priority}</td>
		<td>{$thisRequest->Person->getName()}</td>
		<td id="completed_{$thisRequest->id}">{if $thisRequest->completed == 't'}yes{else}no{/if}</td>
	</tr>
{/foreach}
