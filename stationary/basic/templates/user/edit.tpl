{block name="body"}
<style>
{literal}
#content p {
    padding: 2px;
    padding-bottom: 8px;
}
#content li {
    border: 0px solid black;
    width: 205px;
    list-style-type: none;
    padding: 2px;
}
#content label {
	width: 5em;
	float: left;
	text-align: left;
	margin-right: 0.5em;
	display: block
}
#content .submit input {
	margin-left: 4.5em;
}
#content .submitRow {
    text-align: center;
}
{/literal}

</style>
<p>Enter the information for the new user:</p>
{openform}
<ul>
    <li><label for="username">username:</label> {input id="username" data_object=$person data_field="username"}</li>
    <li><label for="firstname">first name:</label> {input id="firstname" data_object=$person data_field="firstname"}</li>
    <li><label for="lastname">last name:</label> {input id="firstname" data_object=$person data_field="lastname"}</li>
    <li class="submitRow">{input type="submit" name="submit"}</li>
</ul>
{closeform}
{/block}