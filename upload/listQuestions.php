<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormQuestions.php';

use \libAllure\Sanitizer;
use \libAllure\Session;
use \libAllure\ElementHidden;

$sanitizer = new Sanitizer();

if (!Session::isLoggedIn()) {
	redirect('index.php', 'You must be logged in to play!');
}

$team = getTeam();

if (empty($team)) {
	redirect('account.php', 'You dont have a team assigned for this quiz, pick one!');
}

$sql = 'SELECT l.id, l.title FROM levels l WHERE l.id = :levelId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':levelId', $sanitizer->filterUint('level'));
$stmt->execute();

$level = $stmt->fetchrow();

$sql = 'SELECT q.id, q.question, q.imageUrl, if (hint1 is null, 0, 1) AS hintCount FROM questions q JOIN levels l ON q.level = l.id JOIN quizes qu ON l.quiz = qu.id WHERE q.level = :teamLevel AND qu.id = :quizId ORDER BY q.id ASC';
$stmt = $db->prepare($sql);
$stmt->bindValue(':teamLevel', $sanitizer->filterUint('level'));
$stmt->bindValue(':quizId', ACTIVE_QUIZ);
$stmt->execute();
$listQuestions = $stmt->fetchAll();

$sql = 'SELECT p.status FROM team_progress p WHERE p.team = :teamId AND p.level = :level';
$stmt = $db->prepare($sql);
$stmt->bindValue(':teamId', $team['id']);
$stmt->bindValue(':level', $level['id']);
$stmt->execute();

$status = $stmt->fetchRow();

	$f = new FormQuestions();
	$f->addElement(new ElementHidden('level', null, $level['id']));
	$f->setLevelId($sanitizer->filterUint('level'));
	$f->setTeamId($team['id']);
	$f->setTitle('Level: ' . $level['title']);

	foreach ($listQuestions as $singleQuestion) {
		$f->addQuestion($singleQuestion['id'], stripslashes($singleQuestion['question']), $singleQuestion['imageUrl'], $singleQuestion['hintCount']);
	}

	$f->finishedAddingQuestions();

	if ($f->validate()) {
		$f->process();

		redirect('listLevels.php', 'Success, onto the next level!');
	}

$tpl->display('header.tpl');

if ($status != false && $status['status'] == 1) {
	$tpl->display('allQuestionsComplete.tpl');
	$f->getElement('submit')->setCaption('I know this level is completed by I want to complete it again');
}

$tpl->assignForm($f);
$tpl->assign('containerClass', 'answeringForm');
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';


?>
