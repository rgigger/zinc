<table border="1">
	<tr>
		<td>name:</td>
		<td>{$request->name}</td>
	</tr>
	<tr>
		<td>description:</td>
		{*<td>{if $request->html_desc}{$request->html_desc}{else}{$request->text_desc|nl2br}{/if}</td>*}
		<td>{$request->htmlDescription}</td>		
	</tr>
	<tr>
		<td>priority:</td>
		<td>{$request->priority}</td>
	</tr>
</table>

{foreach from=$request->Comment item=comment}
	<div style="border: 1px solid black">
		<p><strong><font size="+3">Comment</font></strong></p>
		{$comment->htmlContent}
	</div>
{/foreach}