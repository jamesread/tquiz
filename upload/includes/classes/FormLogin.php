<?php

require_once 'libAllure/Form.php';

use \libAllure\Form;
use \libAllure\ElementAlphaNumeric;
use \libAllure\ElementPassword;
use \libAllure\Session;

class FormLogin extends Form {
	public function __construct() {
		parent::__construct('formLogin', 'Login');

		$this->addElement(new ElementAlphaNumeric('username', 'Username'));
		$this->addElement(new ElementPassword('password', 'Password'));

		$this->addButtons(Form::BTN_SUBMIT);
	}

	public function validateExtended() {
		try {
			Session::checkCredentials($this->getElementValue('username'), $this->getElementValue('password'));	
		} catch (\libAllure\UserNotFoundException $e) {
			$this->setElementError('username', 'User not found.');
		} catch (\libAllure\IncorrectPasswordException $e) {
			$this->setElementError('password', 'Incorrect password');
		}
	}

	public function process() {
		if (Session::isLoggedIn()) {
			redirect('listLevels.php', 'You have logged in.');
		}
	}
}

?>
