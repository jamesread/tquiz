<?php

require_once 'includes/config.php';

require_once 'vendor/autoload.php';

use \libAllure\ErrorHandler;

$eh = new ErrorHandler();
$eh->beGreedy();

use \libAllure\Database;
use \libAllure\DatabaseFactory;

$db = new Database('mysql:dbname=' . CFG_DB_NAME, CFG_DB_USER, CFG_DB_PASS);
DatabaseFactory::registerInstance($db);

require_once 'includes/functions.php';

define('ACTIVE_QUIZ', intval(getSiteSetting('activeQuiz')));

use \libAllure\Logger;
use \libAllure\AuthBackendDatabase;

$backend = new AuthBackendDatabase();
$backend->setSalt(null, CFG_PASSWORD_SALT);
$backend->registerAsDefault();

use \libAllure\User;
use \libAllure\Session;

Session::setSessionName('tquizUser');
Session::start();

use \libAllure\Template;

$tpl = new Template(CFG_TPL_DIR);

$tpl->assign('ACTIVE_QUIZ', ACTIVE_QUIZ);

if (Session::isLoggedIn()) {
    $tpl->assign('username', Session::getUser()->getUsername());
    $tpl->assign('team', getTeam());
}

$tpl->assign('IS_LOGGED_IN', Session::isLoggedIn());
$tpl->assign('IS_ADMIN', Session::hasPriv('ADMIN'));
$tpl->assign('headerMessage', getSiteSetting('headerMessage'));

?>
