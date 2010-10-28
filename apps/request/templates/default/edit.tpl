{openform}
<table>
	<tr>
		<td>name:</td>
		<td>{$request->name}</td>
	</tr>
	<tr>
		<td>description:</td>
		<td>{$request->htmlDescription}</td>		
	</tr>
	<tr>
		<td>priority:</td>
		<td>{input type="select" data_object=$request data_field="priority_id" option_table="priority"}</td>
	</tr>
	<tr>
		<td>status:</td>
		<td>{input type="select" data_object=$request data_field="status_id" option_table="status"}</td>
	</tr>
	<tr>
		<td colspan="2">
			<input name="submitAction" value="Save" type="submit">
			<input name="submitAction" value="Delete" type="submit" style="float: right">
		</td>
	</tr>
</table>
{closeform}