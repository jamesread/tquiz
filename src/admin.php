<?php

require_once 'includes/common.php';
require_once 'includes/classes/FormTeamReset.php';

use \libAllure\Session;

if (!Session::hasPriv('ADMIN')) {
    redirect('account.php', 'You are not an admin');;
}

$tpl->display('header.tpl');
$tpl->display('admin.tpl');

require_once 'includes/widgets/footer.php';

?>
