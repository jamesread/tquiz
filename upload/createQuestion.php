<?php

require_once 'includes/common.php';

use \libAllure\Sanitizer;

$sanitizer = new Sanitizer();

$sql = 'INSERT INTO questions (question, level) VALUES ("question", :levelId)';
$stmt = $db->prepare($sql);
$stmt->bindValue(':levelId', $sanitizer->filterUint('levelId'));
$stmt->execute();

redirect('editQuestion.php?formEditQuestion-id=' . $db->lastInsertId(), 'Created, going to edit now.');

?>
