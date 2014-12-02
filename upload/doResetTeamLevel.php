<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormTeamReset.php';

$f = new FormTeamReset();

if ($f->validate()) {
	$f->process();
	redirect('admin.php');
}

$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');
require_once 'includes/widgets/footer.php';

?>
