<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormNewQuiz.php';


$f = new FormNewQuiz();

if ($f->validate()) {
    $f->process();

    redirect('listQuizes.php', 'Created.');
}

$tpl->display('header.tpl');

$tpl->assignForm($f);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';

?>
