<h2>Account: {$username}</h2>

<div style = "width: 40%; display: inline-block; vertical-align: top;">
	{if $team}
	<blockquote>
		<p><strong>Team</strong>: {$team.title}</p>
		<p><strong>Registered</strong>: {$registered|default:"(unknown)"}</p>
	</blockquote>
	{else}
	<p>No team set.</p>
	{/if}

	<h3>Active quizes</h3>
	{if empty($listJoinedQuizes)}
	<em>No active quizes</em>
	{else}
		<ul>
		{foreach from = $listJoinedQuizes item = "quiz"}
			<li><a href = "listLevels.php">{$quiz.title}</a></li>
		{/foreach}
		</ul>
	{/if}

	<h3>Misc</h3>
	<a href = "logout.php">Logout</a>
</div>
