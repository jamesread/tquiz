<?php

require_once 'includes/common.php';

requirePrivOrRedirect('LIST_USERS', 'index.php');

$sql = 'SELECT u.id, u.username, u.registered, t.title AS teamTitle FROM users u LEFT JOIN team_memberships tm ON tm.user = u.id LEFT JOIN teams t ON tm.team = t.id ORDER BY u.username';
$stmt = $db->prepare($sql);
$stmt->execute();

$tpl->assign('userlist', $stmt->fetchAll());
$tpl->display('listUsers.tpl');

require_once 'includes/widgets/footer.php';

?>
