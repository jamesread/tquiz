<?php

require_once 'includes/common.php';

requirePrivOrRedirect('LIST_USERS', 'index.php');

$sql = 'SELECT u.id, u.username, u.registered, t.title AS teamTitle FROM team_memberships tm JOIN users u ON tm.user = u.id JOIN teams t ON tm.team = t.id WHERE tm.quiz = :activeQuiz ORDER BY u.username';
$stmt = $db->prepare($sql);
$stmt->bindValue(':activeQuiz', ACTIVE_QUIZ);
$stmt->execute();

$tpl->assign('userlist', $stmt->fetchAll());
$tpl->display('listUsers.tpl');

require_once 'includes/widgets/footer.php';

?>
