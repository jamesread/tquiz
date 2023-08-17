<div style = "width: 50%; margin: auto; text-align: center;">
	<h2>Welcome to <strong>tquiz</strong>!</h2>
	
	<p>This is a team-quiz on the tinterwebnets.</p>

	<p>The idea is that as a team, you answer questions on gaming, technoloy, films and stuff. But this isn't any normal quiz, you are allowed to use search engines to find the answer! </p>

	{if $IS_LOGGED_IN} 
	<p>Now that you are logged in, go to the <a href = "listLevels.php">questions</a> or the <a href = "listTeams.php">teams list</a>!</p>
	{else}
	<p>You can play solo (team of 1), or in a team of up to 3 people. To get started, <a href = "doRegister.php">register</a> or <a href = "login.php">login</a>. </p>
	{/if}
</div>
