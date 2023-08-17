<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (Session::isLoggedIn()) {
    redirect('account.php', 'You are already logged in.');
}

require_once 'includes/classes/FormLogin.php';

$formLogin = new FormLogin();

if ($formLogin->validate()) {
    $formLogin->process();
}

$tpl->display('header.tpl');

$tpl->assignForm($formLogin);
$tpl->display('login.tpl');

require_once 'includes/widgets/footer.php';

