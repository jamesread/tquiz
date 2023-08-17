<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormRegister.php';

use \libAllure\Session;

if (Session::isLoggedIn()) {
    redirect('account.php', 'You cannot register an account while logged in!');
}

$tpl->display('header.tpl');

$registrationBlockMessage = getSiteSetting('registrationBlockMessage');

if (!empty($registrationBlockMessage)) {
    $tpl->assign('message', '<p style = "font-size: large; text-align: center; color: red;">' . $registrationBlockMessage . '</p>');
    $tpl->display('notification.tpl');
} else {
    $f = new FormRegister();

    if ($f->validate()) {
        $f->process('login.php', 'Your account has been registered, now login!');
    }

    $tpl->assignForm($f);
    $tpl->display('register.tpl');
}

require_once 'includes/widgets/footer.php';

?>
