<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (!Session::isLoggedIn()) {
    redirect('login.php', 'Login to access your account');
}

$tpl->display('header.tpl');

$tpl->assign('username', Session::getUser()->getUsername());
$tpl->assign('registered', Session::getUser()->getData('registered'));

$sql = 'SELECT t.title AS teamTitle, q.title, q.id FROM team_memberships tm JOIN quizes q ON tm.quiz = q.id JOIN teams t ON tm.team = t.id JOIN users u ON tm.user = u.id WHERE tm.user = :userId'; 
$stmt = $db->prepare($sql);
$stmt->bindValue(':userId', Session::getUser()->getId());
$stmt->execute();

$res = $stmt->fetchAll();
$tpl->assign('listJoinedQuizes', $res);

$tpl->display('account.tpl');
require_once 'includes/widgets/footer.php';

?>
