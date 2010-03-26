<div class="entry" style="margin-bottom: 20px; margin-top: 20px">
	{if $isList}
		<h3><a href="{$scriptUrl}/entry/1/{$entry->getDateNameUrl()}">{$entry->title}</a></h3>
	{else}
		<h3>{$entry->title}</h3>
	{/if}
	<h4>{$entry->published_date|date_format}{if $entry->link} - <a target="_new" href="{$entry->link}">{if $entry->link_text}{$entry->link_text}{else}I want to go to there{/if}</a>{/if}</h4>
	{$entry->getContent()}
</div>
