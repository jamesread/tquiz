<?php

require_once 'includes/common.php';

requirePrivOrRedirect('READ_QUIZ', 'index.php');

use \libAllure\Sanitizer;

$sanitizer = new Sanitizer();

$sql = 'SELECT q.id, q.question, q.answer, q.imageUrl, q.level, qu.id AS quiz FROM questions q JOIN levels l ON q.level = l.id JOIN quizes qu ON l.quiz = qu.id WHERE l.id = :levelId ORDER BY q.level ASC, q.id ASC';
$stmt = $db->prepare($sql);
$stmt->bindValue(':levelId', $sanitizer->filterUint('level'));
$stmt->execute();

$listQuestions = $stmt->fetchAll();

$sql = 'SELECT l.id, l.title, l.quiz, q.title AS quizTitle FROM levels l JOIN quizes q ON l.quiz = q.id WHERE l.id = :levelId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':levelId', $sanitizer->filterUint('level'));
$stmt->execute();

$itemLevel = $stmt->fetchRow();

$tpl->display('header.tpl');
$tpl->assign('level', $itemLevel);
$tpl->display('viewLevel.tpl');
$tpl->assign('questionsList', $listQuestions);
$tpl->display('questionsList.tpl');
require_once 'includes/widgets/footer.php';

?>
