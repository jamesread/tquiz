<?php 

require_once 'includes/common.php';

$tpl->display('header.tpl');
$tpl->display('home.tpl');

$tpl->assign('sponsorMessage', getSiteSetting('sponsorMessage'));
$tpl->display('sponsors.tpl');

require_once 'includes/widgets/footer.php';

?>
