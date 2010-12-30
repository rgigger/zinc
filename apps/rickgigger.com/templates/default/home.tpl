{foreach from=$entries item=entry}
	{include file="shared/entry.tpl" short=true}
{/foreach}
<div style="text-align: center">
	<p>pages</p>
	{foreach from=$pages item=i}
		<a href="{$zoneUrl}/home/{$i}">{$i}</a>
	{/foreach}
</div>
