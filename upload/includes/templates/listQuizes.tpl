{include file = "header.tpl"}
<h2><a href = "admin.php">Admin</a> &raquo; Quizes</h2>

<h3>List Actions</h3>
<ul>
	<li><a href = "createQuiz.php">Ceate Quiz</a></li>
</ul>

<h3>List of Quizes</h3>
<p>This is a list of quizes. The active quiz is {$ACTIVE_QUIZ}, quizes with 0 questions are hidden. </p>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Level count</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{foreach from = "$quizes" item = "quiz"}
		<tr>
			<td>{if $ACTIVE_QUIZ eq $quiz.id}<strong>{$quiz.id}</strong>{else}{$quiz.id}{/if}</th>
			<td><a href = "viewQuiz.php?id={$quiz.id}">{$quiz.title}</a></td>
			<td>{$quiz.levelCount}</td>
			<td><a href = "updateQuiz.php?id={$quiz.id}">Update</a></td>
		</tr>
		{/foreach}
	</tbody>
</table>

{include file = "footer.tpl"}
