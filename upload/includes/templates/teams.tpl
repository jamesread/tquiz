<h2>Team Scoreboard</h2>
<p><strong>Your team:</strong> {$team.title}</p>
<p>These are the other registered teams. Rank is by the <abbr title = "In descending order">number of levels completed</abbr>, then time since <abbr title = "In ascending order">date of registeration</abbr> (ie: a team the completes the levels in less time will be a higher rank than a team that takes longer).</p>

<h3>Rankings</h3>
{if $teamList|@count eq 0}
	<p>No teams :(</p>
{else}
	<table>
		<thead>
			<tr>
				<th>Rank</th>
				<th>Title</th>
				<th>Members</th>
				<th>Registered</th>
				<th>Levels completed</th>
			</tr>
		</thead>

		<tbody>
		{foreach from = "$teamList" item = team name = "teamList"} 
			<tr>
				<td><strong>{$team.rank}</strong></td>
				<td>
				{if $team.id eq $usersTeam.id}
					<strong><u>{$team.title}</u></strong>
				{else}
					{$team.title}
				{/if}
					<br /><small>Team id: {$team.id}, Size: {$team.userCount} members.</small>
				</td>
				<td>{$team.members}</td>
				<td>{$team.registered}<br /><small>Playing for {$team.registeredRelative}</small></td>
				<td>{$team.level}</td>
			</tr>
		{/foreach}
		</tbody>

	</table>
{/if}
