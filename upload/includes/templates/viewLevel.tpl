<h2><a href = "admin.php">Admin</a> &raquo; <a href = "listQuizes.php">Quizes</a> &raquo; <a href = "viewQuiz.php?id={$level.quiz}">{$level.quizTitle}</a> &raquo; Level: {$level.title}</h2>

<h3>Item Info</h3>
<p>
	<strong>ID:</strong> {$level.id}<br />
	<strong>Title:</strong> {$level.title}
</p>
<h3>Item Actions</h3>
<ul>
	<li><a href = "editLevel.php?level={$level.id}">Edit level</a></li>
	<li><a href = "createQuestion.php?level={$level.id}">Create question</a></li>
</ul>
