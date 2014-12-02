<?php

require_once 'includes/config.php';
require_once 'libAllure/Database.php';

require_once 'libAllure/ErrorHandler.php';
use \libAllure\ErrorHandler;

$eh = new ErrorHandler();
$eh->beGreedy();

use \libAllure\Database;
use \libAllure\DatabaseFactory;

$db = new Database('mysql:dbname=' . CFG_DB_NAME , CFG_DB_USER, CFG_DB_PASS);
DatabaseFactory::registerInstance($db);

require_once 'includes/functions.php';

define ('ACTIVE_QUIZ', intval(getSiteSetting('activeQuiz')));

require_once 'libAllure/Logger.php';
use \libAllure\Logger;

require_once 'libAllure/AuthBackend.php';
require_once 'libAllure/AuthBackendDatabase.php';

use \libAllure\AuthBackendDatabase;

$backend = new AuthBackendDatabase();
$backend->setSalt(null, CFG_PASSWORD_SALT);
$backend->registerAsDefault();

require_once 'libAllure/User.php';
use \libAllure\User;

require_once 'libAllure/Session.php';
use \libAllure\Session;

Session::setSessionName('tquizUser');
Session::start();

require_once 'libAllure/Template.php';
use \libAllure\Template;

require_once 'libAllure/Inflector.php';

$tpl = new Template(CFG_TPL_DIR);

$tpl->assign('ACTIVE_QUIZ', ACTIVE_QUIZ);

if (Session::isLoggedIn()) {
	$tpl->assign('username', Session::getUser()->getUsername());
	$tpl->assign('team', getTeam());
}

$tpl->assign('IS_LOGGED_IN', Session::isLoggedIn());
$tpl->assign('IS_ADMIN', Session::hasPriv('ADMIN'));
$tpl->assign('headerMessage', getSiteSetting('headerMessage'));

require_once 'libAllure/Form.php';
require_once 'libAllure/Sanitizer.php';

?>
