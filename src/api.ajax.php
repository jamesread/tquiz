<?php

require_once 'includes/common.php';

if (isset($_REQUEST['action'])) {
    define('ACTION', $_REQUEST['action']);
}

define('ID', intval($_REQUEST['id']));

switch (ACTION) {
case 'question-move-up';
    $sql = 'UPDATE questions set position = position - 1 WHERE question = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', ID);
    $stmt->execute();

    break;
case 'question-move-down';
    $sql = 'UPDATE questions SET position = position + 1 WHERE question = :id ';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', ID);
    $stmt->execute();
    break;
}

echo json_encode(array('status' => 'OK'));

?>
