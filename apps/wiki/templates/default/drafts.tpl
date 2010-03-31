<style>
{literal}
th, td {
	padding: 10px
}
{/literal}
</style>
<h2>Drafts</h2>
<table>
	<tr>
		<th>id</th>
		<th>name</th>
		<th>title</th>
	</tr>
	{foreach from=$entries item=entry}
	<tr>
		<td><a href="{$scriptUrl}/entry/2/{$entry->id}">{$entry->id}</a></td>
		<td>{$entry->name}</td>
		<td>{$entry->title}</td>
	</tr>
	{/foreach}
</table>
