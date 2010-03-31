{foreach from=$entries item=entry}
	<p><a href="{$scriptUrl}/entry/{$entry->id}">{$entry->title}</a></p>
{/foreach}