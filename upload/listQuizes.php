<?php

require_once 'includes/common.php';

use \libAllure\DatabaseFactory;

requirePrivOrRedirect('LIST_QUIZES', 'index.php');

$sql = 'SELECT q.id, q.title, count(l.id) AS levelCount FROM quizes q LEFT JOIN levels l ON l.quiz = q.id GROUP BY q.id ORDER BY q.title';
$stmt = DatabaseFactory::getInstance()->prepare($sql);
$stmt->execute();

$tpl->assign('quizes', $stmt->fetchAll());
require_once 'includes/widgets/footer.php';

?>
