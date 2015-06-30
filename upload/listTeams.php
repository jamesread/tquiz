<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (!Session::isLoggedIn()) {
	redirect('login.php', 'You need to login to see teams.');
}

$tpl->display('header.tpl');

$sql = 'SELECT t.id, t.title, t.userCount, t.registered, count(p.id) AS level FROM teams t LEFT JOIN team_progress p ON p.team = t.id WHERE t.quiz = :activeQuiz AND t.isPrivate = 0 GROUP BY t.id ORDER BY level DESC, registered DESC';
$stmt = $db->prepare($sql);
$stmt->bindValue(':activeQuiz', ACTIVE_QUIZ);
$stmt->execute();
$teamList = $stmt->fetchAll();

$tpl->assign('usersTeam', getTeam());

foreach ($teamList as $rank => &$team) {
	// Calc members
	$sql = 'SELECT u.id, u.username, tm.team FROM team_memberships tm JOIN users u ON tm.user = u.id WHERE tm.team = :teamId AND tm.quiz = :activeQuiz';
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':teamId', $team['id']);
	$stmt->bindValue(':activeQuiz', ACTIVE_QUIZ);
	$stmt->execute();

	$usernames = array();
	foreach ($stmt->fetchAll() as $teamMember) {
		$usernames[] = $teamMember['username'];
	}
	
	$dateInterval = date_diff(new DateTime($team['registered']), new DateTime());
	$team['registeredRelative'] = $dateInterval->d . ' days, ' . $dateInterval->h . ' hours, ' . $dateInterval->i . ' minutes.';
	$team['members'] = implode(', ', $usernames);

	// Calc rank
	$rank++;
	$team['rank'] = ($rank) . getOrdinalSuffix($rank);
}

$tpl->assign('teamList', $teamList);

$tpl->display('teams.tpl');
require_once 'includes/widgets/footer.php';

?>
