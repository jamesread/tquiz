<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormEditLevel.php';

use \libAllure\Sanitizer;

$sanitizer = new Sanitizer();

$f = new FormEditLevel();

if ($f->validate()) {
	$f->process();

	redirect('viewLevel.php?level=' . $sanitizer->filterUint('level'), 'Updated level.');
}

$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');
require_once 'includes/widgets/footer.php';

?>
