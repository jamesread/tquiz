<div style = "text-align: center;">
	{if empty($team)}
	<h2>No Team</h2>
	{else}
	<h2>{$team.title}</h2>
	<strong>Team progress:</strong>
	<div style = "display: inline-block; width: 100px; border: 1px solid black; background-color: salmon;">
		<div class = "progressBar" style = "width: {$completedness}px; background-color: lightgreen;">&nbsp;</div>
	</div>
	<p>{$completedLevels|@count} levels complete out of {$listLevels|@count} total levels</p>
	{/if}
</div>
<br />

<div class = "listLevels">
{foreach from = $listLevels item = "level"}
	<div class = "levelSelect">
		<a href = "listQuestions.php?level={$level.id}">
			<p class = "title {if $level.status}good{else}bad{/if}">
				<strong>{$level.title}</strong>
			</p>
			<img src = "resources/images/levels/{$level.image}" alt = "level{$level.id}" />
		</a>
	</div>
{/foreach}
</div>
