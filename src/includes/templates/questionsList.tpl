
<h3>Child items: Questions list</h3>

<script type = "text/javascript" src = "resources/javascript/jquery.js"></script>
<script type = "text/javascript" src = "resources/javascript/jquery.tablednd_0_5.js"></script>

{if empty($questionsList)}
<p>There are 0 questions.</p>
{else}
<table id = "questionsTable">
	<thead>
		<tr>
			<th>ID</th>	
			<th>Question</th>	
			<th>Image URL</th>	
			<th>Answer</th>	
			<th>Level</th>	
		</tr>
	</thead>

	<tbody>
{foreach from = $questionsList item = "question"}
	<tr>
		<td><a href = "editQuestion.php?formEditQuestion-id={$question.id}">{$question.id}</a></td>
		<td>{$question.question}</td>
		<td>
		{if $question.imageUrl eq ''}
			N/A
		{else}
			<a href = "editQuestion.php?formEditQuestion-id={$question.id}">
			<img src = "resources/images/questions/{$question.imageUrl}" width = "100" alt = "image for question {$question.id}" />
			</a>
		{/if}
		</td>
		<td>{$question.answer}</td>
		<td>{$question.level}</td>
	</tr>
{/foreach}
	</tbody>

</table>
{/if}
