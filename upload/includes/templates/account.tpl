<h2>Account: {$username}</h2>

<div style = "width: 40%; display: inline-block; vertical-align: top;">
	<blockquote>
		<p><strong>Team</strong>: {$team.title}</p>
		<p><strong>Registered</strong>: {$registered|default:"(unknown)"}</p>
	</blockquote>

	<h3>Active quizes</h3>
	<ul>
	{foreach from = "$listJoinedQuizes" item = "quiz"}
		<li><a href = "listLevels.php">{$quiz.title}</a></li>
	{/foreach}
	</ul>

</div>
