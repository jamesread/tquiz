<?php

require_once 'includes/common.php';

use \libAllure\Sanitizer;
use \libAllure\DatabaseFactory;

requirePrivOrRedirect('READ_QUIZ', 'index.php');

$sanitizer = new Sanitizer();

$quiz = $sanitizer->filterUint('id');

if ($quiz == null) {
	$quiz = ACTIVE_QUIZ;
}

$sql = 'SELECT q.id, q.title FROM quizes q WHERE q.id = :id';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
$stmt->bindValue(':id', $quiz);
$stmt->execute();

$quiz = $stmt->fetchRow();

$sql = 'SELECT l.id, l.title, l.ordinal, (SELECT count(q.id) FROM questions q WHERE q.level = l.id) AS questionCount FROM levels l WHERE l.quiz = :quizId GROUP BY l.id ORDER BY l.ordinal ASC, l.title ASC';
$stmt = $db->prepare($sql);
$stmt->bindValue(':quizId', $quiz['id']);
$stmt->execute();

$listLevels = $stmt->fetchAll();

foreach ($listLevels as &$level) {
	$level['hasImage'] = file_exists('resources/images/levels/level' . $level['id'] . '.png');
}

$tpl->assign('quiz', $quiz);
$tpl->assign('listLevels', $listLevels);
$tpl->display('viewQuiz.tpl');

require_once 'includes/widgets/footer.php';

?>
