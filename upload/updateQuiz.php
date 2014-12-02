<?php

use \libAllure\Sanitizer;

require_once 'includes/common.php';
require_once 'includes/classes/FormEditQuiz.php';

$sanitizer = new Sanitizer();

$f = new FormEditQuiz($sanitizer->filterUint('id'));

if ($f->validate()) {
	$f->process();
	redirect('viewQuiz.php?id=' . $sanitizer->filterUint('id'), 'Quiz edited.');
}

$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');
require_once 'includes/widgets/footer.php';

?>
