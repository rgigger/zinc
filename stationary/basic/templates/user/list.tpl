{block name="body"}
<style>
{literal}
#info {
    text-align: center;
    width: 100%;
    border: 0px solid black;
}
#content button.send {
    padding: 5px;
}
{/literal}
</style>

<script>
$(document).ready( function() {
    $('.send').click( function() {
		var personId = $(this).attr('data-id');
		var url = zoneUrl + '/sendEmail/' + personId;
		$.post(url , function(data) {
			// alert(data);
		});
    });
});
</script>

<div id="info">
<table class="data">
    <tr>
        <th>id</th>
        <th>username</th>
        <th>firstname</th>
        <th>lastname</th>
        <th>password set</th>
    </tr>
{foreach from=$people item=person}
    <tr>
        <td>{$person->id}</td>
        <td>{$person->username}</td>
        <td>{$person->firstname}</td>
        <td>{$person->lastname}</td>
        <td>{if !is_null($person->password)}x{else}<button class="send" data-id="{$person->id}">send email</button>{/if}</td>
    </tr>
{/foreach}
</table>
<a href="{$zoneUrl}/edit/">add</a></div>
{/block}