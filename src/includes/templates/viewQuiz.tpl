{include file = "header.tpl"}

<h2><a href = "admin.php?">Admin</a> &raquo; <a href = "listQuizes.php">Quizes</a> &raquo; {$quiz.title}</h2>

<h3>Item Actions</h3>

<ul>
	<li><a href = "updateQuiz.php?id={$quiz.id}">Update</a></li>
	<li><a href = "deleteQuiz.php?id={$quiz.id}">Delete quiz</a></li>
	<li><a href = "createLevel.php?quiz={$quiz.id}">Create level</a></li>
</ul>

<h3>Child items: Levels list</h3>

{if $listLevels|@count eq 0}
	<p>This quiz does not heve any levels yet.</p>
{else}
	<table>
		<thead>
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Level image</th>
				<th>Ordinal</th>
				<th>Question count</th>
			</tr>
		</thead>

		<tbody>
		{foreach from = $listLevels item = "level"}
			<tr>
				<td><a href = "viewLevel.php?level={$level.id}">{$level.id}</a></td>
				<td><a href = "viewLevel.php?level={$level.id}">{$level.title}</a></td>
				<td>
				{if $level.hasImage}
				<img src = "resources/images/levels/level{$level.id}.png" alt = "levelImage" width = "100" />
				{/if}
				</td>
				<td>{$level.ordinal}</td>
				<td>{$level.questionCount}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{/if}
