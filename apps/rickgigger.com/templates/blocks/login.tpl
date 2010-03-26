{if $loggedInUser}
	<h3>Welcome {$loggedInUser->username}!</h3>
{else}
	<h3>Login</h3>
	<form action="{$scriptUrl}/login" method="post">
		Username: <input type="text" name="username">
		Password: <input type="password" name="password">	
		<input type="submit">
	</form>
	<br>
{/if}