<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormSiteSettings.php';

$f = new FormSiteSettings();

if ($f->validate()) {
    $f->process();
    redirect('admin.php', 'Site settings saved.');
}


$tpl->display('header.tpl');
$tpl->assignForm($f);
$tpl->display('form.tpl');

require_once 'includes/widgets/footer.php';

?>
