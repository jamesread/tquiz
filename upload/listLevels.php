<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (!Session::isLoggedIn()) {
	redirect('index.php', 'You must be logged in to do this.');
}

$team = getTeam();

$sql = 'SELECT l.id, l.title, p.status, 0 AS qCount FROM levels l LEFT JOIN team_progress p ON p.level = l.id AND p.team = :teamId WHERE l.quiz = :activeQuiz ORDER By l.ordinal ASC, l.title ASC ';
$stmt = $db->prepare($sql);
$stmt->bindValue(':activeQuiz', ACTIVE_QUIZ);
$stmt->bindValue(':teamId', $team['id']);
$stmt->execute();
$listLevels = $stmt->fetchAll();

if (count($listLevels) == 0) {
	redirect('index.php', 'There are 0 levels for this quiz!');
} else {
	foreach ($listLevels as $key => $level) {
		if (file_exists('resources/images/levels/level' . $level['id'] . '.png')) {
			$listLevels[$key]['image'] = 'level' . $level['id'] . '.png';
		} else {
			$listLevels[$key]['image'] = 'defaultLevel.png';
		}
	}
}

$sql = 'SELECT l.id FROM team_progress p JOIN levels l ON p.level = l.id WHERE l.quiz = :activeQuiz AND p.status = 1 AND p.team = :team';
$stmt = $db->prepare($sql);
$stmt->bindValue(':activeQuiz', ACTIVE_QUIZ);
$stmt->bindValue(':team', $team['id']);
$stmt->execute();
$completedLevels = $stmt->fetchAll();

$tpl->display('header.tpl');

if (count($completedLevels) == count($listLevels)) {
	$tpl->display('allLevelsComplete.tpl');
}

$tpl->assign('completedness', intval((count($completedLevels) / count($listLevels)) * 100));
$tpl->assign('completedLevels', $completedLevels);
$tpl->assign('listLevels', $listLevels);
$tpl->assign('team', $team);
$tpl->display('listLevels.tpl');

require_once 'includes/widgets/footer.php';

?>
