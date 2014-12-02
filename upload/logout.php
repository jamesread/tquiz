<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (!Session::isLoggedIn()) {
	redirect('index.php', 'You are not logged in.');
}

Session::logout();

redirect('index.php', 'See ya later.');

?>
