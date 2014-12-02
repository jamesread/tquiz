<?php

require_once 'libAllure/Inflector.php';
require_once 'libAllure/Form.php';

use \libAllure\Form;
use \libAllure\ElementHtml;
use \libAllure\ElementPassword;
use \libAllure\ElementAlphaNumeric;
use \libAllure\ElementSelect;
use \libAllure\Session;
use \libAllure\Logger;
use \libAllure\Inflector;

class FormRegister extends Form {
	public function __construct() {
		parent::__construct('formRegister', 'Register a new account');

		$this->addElement(new ElementHtml('userDetailsTitle', null, '<strong>User details</strong>'));
		$this->addElement(new ElementAlphaNumeric('username', 'Username'));
		$this->addElement(new ElementPassword('password1', 'Password'));
		$this->addElement(new ElementPassword('password2', 'Password (confirm)'));
		$this->addElement(new ElementHtml('teamTitle', null, '<strong>Team</strong>'));
		$this->addElement($this->getExistingTeamSelectionElement());

		$this->addElement(new ElementAlphaNumeric('newTeamName', 'New team name', null, 'If you are joining an existing team, leave this blank.' ));
		$this->getElement('newTeamName')->setMinMaxLengths(0, 100);	
	
		$this->addButtons(Form::BTN_SUBMIT);
	}

	public function getExistingTeamSelectionElement() {
		global $db;

		$el = new ElementSelect('teamExistingSelect', 'Existing team', null, 'The list of available teams to join, full teams are hidden, maximum of 3 people per team.');
		$el->addOption('(none)', 0);
		$el->setSize(10);

		$sql = 'SELECT t.id, t.title, t.userCount FROM teams t WHERE t.userCount < 3 AND t.isPrivate = 0 ORDER BY t.title ASC';
		$stmt = $db->prepare($sql);
		$stmt->execute();


		foreach ($stmt->fetchAll() as $existingTeam) {
			$slotsFree = 3 - $existingTeam['userCount'];
			$el->addOption($existingTeam['title'] . ' &nbsp;&nbsp;&nbsp;&nbsp; (' . $slotsFree . ' ' . Inflector::quantify('slots', $slotsFree) . ' free)</u>', $existingTeam['id']);
		}

		return $el;
	}

	public function validateExtended() {
		$this->validateUsername();
		$this->validatePassword();
		$this->validateTeam();
	}

	private function validateTeam() {
		if ($this->getElementValue('teamExistingSelect') != 0 && $this->getElementValue('newTeamName') != '') {
			$this->setElementError('newTeamName', 'Select a team, or create one, not both you special person.');
		} else if ($this->getElementValue('teamExistingSelect') != 0) {
			$this->selectedTeamId = $this->getElementValue('teamExistingSelect');
		} else if ($this->getElementValue('newTeamName') != null) {
			global $db;

			$sql = 'SELECT title FROM teams WHERE title = :title';
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':title', $this->getElementValue('newTeamName'));
			$stmt->execute();

			if ($stmt->numRows() != 0) {
				$this->setElementError('newTeamName', 'Somebody already chose that team name');
				return;
			}			
		} else {
			$this->setElementError('teamExistingSelect', 'Choose a team, or create one.');
		}
	}

	private function validateUsername() {
		global $db;

		if (strlen($this->getElementValue('username')) < 4) {
			$this->setElementError('username', 'Username should be more than 4 chars.');
		}

//		if (preg_match('/[a-z|0-9]+/i', $this->getElementValue('username')) != 1) {
//			$this->setElementError('username', 'Invalid characters used, only alphanumeric characters are permitted (a-z, 0-9). ');
//		}

		$sql = 'SELECT username FROM users WHERE username = :username';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $this->getElementValue('username'));
		$stmt->execute();

		if ($stmt->numRows() > 0) {
			$this->setElementError('username', 'That username has already been taken.');
		}	
	}

	private function validatePassword() {
		if (strlen($this->getElementValue('password1')) < 6) {
			$this->setElementError('password1', 'Please provide a password which is at least 6 characters long before you get h4xed.');
		}

		if ($this->getElementValue('password1') != $this->getElementValue('password2')) {
			$this->setElementError('password2', 'Passwords do not match.');
		}

	}

	public function process() {
		global $db;

		$db->beginTransaction();

		if (empty($this->selectedTeamId)) {
			$sql = 'INSERT INTO teams (title, registered, quiz) VALUES (:title, now(), :quiz) ';
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':title', $this->getElementValue('newTeamName'));
			$stmt->bindValue(':quiz', ACTIVE_QUIZ);
			$stmt->execute();

			$this->selectedTeamId = $db->lastInsertId();
		}

		$sql = 'INSERT INTO users (username, password, registered) VALUES (:username, :password, now()) ';	
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $this->getElementValue('username'));
		$stmt->bindValue(':password', sha1($this->getElementValue('password1') . CFG_PASSWORD_SALT));
		$stmt->execute();

		$this->userId = $db->lastInsertId();

		$sql = 'INSERT INTO team_memberships (user, team, quiz) VALUES (:user, :team, :quiz) ';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user', $this->userId);
		$stmt->bindValue(':team', $this->selectedTeamId);
		$stmt->bindValue(':quiz', ACTIVE_QUIZ);
		$stmt->execute();

		$sql = 'UPDATE teams t SET t.userCount = t.userCount + 1 WHERE t.id = :teamId ';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':teamId', $this->selectedTeamId);
		$stmt->execute();

		$db->commit();

		Logger::messageNormal('New user registration: ' . $this->getElementValue('username'));

		redirect('login.php?formLogin-username=' . $this->getElementValue('username'), 'Registeration complete!');
	}

}

?>
