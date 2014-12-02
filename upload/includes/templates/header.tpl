<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>
	<title>tquiz</title>

	<link rel = "stylesheet" type = "text/css" href = "resources/stylesheets/main.css" />
</head>

<body>
	<div class = "header">
		{if isset($username)}
		<h1><a href = "account.php">{$username}</a> - <a href = "listTeams.php">{$team.title|default:'(no team)'}</a> - tquiz</h1>
		{else}
		<h1>tquiz</h1>
		{/if}
		
		<div class = "navigation">
		<a href = "index.php">Home</a>
		{if $IS_LOGGED_IN}
			<a href = "listLevels.php">Play!</a>
			<a href = "listTeams.php">Team Scoreboard</a>

			{if $IS_ADMIN}
			<a href = "admin.php">Admin</a>	
			{/if}

			<a href = "logout.php">Logout</a>
		{else}
			<a href = "login.php">Login</a>
			<a href = "doRegister.php">Register</a>
		{/if}
		</div>
	</div>

	{if not empty($headerMessage)}
	<p class = "headerMessage">Message: {$headerMessage}</p>
	{/if}

	<div class = "content">
