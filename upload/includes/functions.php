<?php

use \libAllure\DatabaseFactory;
use \libAllure\Session;

function getSiteSetting($keyName) {
	$sql = 'SELECT s.value FROM site_settings s WHERE s.`key` = :key';
	$stmt = DatabaseFactory::getInstance()->prepare($sql);
	$stmt->bindValue(':key', $keyName);
	$stmt->execute();

	$value = $stmt->fetchRow();
	$value = $value['value'];

	return $value;
}

function getTeam() {
	$sql = 'SELECT t.id, t.title FROM team_memberships tm JOIN quizes q ON tm.quiz = q.id JOIN teams t ON tm.team = t.id JOIN users u ON tm.user = u.id WHERE tm.user = :userId AND tm.quiz = :quizId LIMIT 1';
	$stmt = DatabaseFactory::getInstance()->prepare($sql);
	$stmt->bindValue(':userId', Session::getUser()->getId());
	$stmt->bindValue(':quizId', constant('ACTIVE_QUIZ'));
	$stmt->execute();
	$team = $stmt->fetchRow();

	return $team;
}

function getOrdinalSuffix($value) {
     if(substr($value, -2, 2) == 11 || substr($value, -2, 2) == 12 || substr($value, -2, 2) == 13){
         $suffix = "th";
     }
     else if (substr($value, -1, 1) == 1){
         $suffix = "st";
     }
     else if (substr($value, -1, 1) == 2){
         $suffix = "nd";
     }
     else if (substr($value, -1, 1) == 3){
         $suffix = "rd";
     }
     else {
         $suffix = "th";
     }

     return $suffix;
}

function requirePrivOrRedirect($priv, $redirectUrl) {
	if (!Session::hasPriv($priv)) {
		redirect($redirectUrl, 'You dont have permission to do this, redirecting.');
	}
}

function redirect($url, $reason) {
	global $tpl;

	if (!in_array('includes/widgets/header.php', get_included_files())) {
		$tpl->assign('redirectUrl', $url);
		$tpl->display('header.minimal.tpl');
	}

	echo '<h2>Redirecting: '  . $reason.  '</h2>';
	echo '<p>You are being redirected to <a href = "' . $url . '">here</a>.</p>';

	$tpl->display('footer.minimal.tpl');
}



?>
