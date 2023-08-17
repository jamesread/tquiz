<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormEditQuestion.php';

use \libAllure\Session;

Session::requirePriv('EDITQUESTION');

$f = new FormEditQuestion($_REQUEST['formEditQuestion-id']);

if ($f->validate()) {
    $f->process();
    redirect('viewLevel.php?level=' . $f->getElementValue('level'), 'Edited.');
}


$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');
require_once 'includes/widgets/footer.php';

?>
