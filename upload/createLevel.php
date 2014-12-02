<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormNewLevel.php';

use \libAllure\Sanitizer;

$sanitizer= new Sanitizer();

$f = new FormNewLevel($sanitizer->filterUint('quiz'));

if ($f->validate()) {
	$f->process();

	redirect('viewQuiz.php?id=' . $sanitizer->filterUint('quiz'), 'New level');
}

$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';

?>
