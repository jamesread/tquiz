<?php 

require_once 'includes/common.php';

$tpl->display('header.tpl');
$tpl->display('home.tpl');

$tpl->assign('sponsorMessage', getSiteSetting('sponsorMessage'));
$tpl->display('sponsors.tpl');
$tpl->display('footer.tpl');

?>
