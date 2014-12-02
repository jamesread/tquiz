<?php

use \libAllure\Form;
use \libAllure\ElementInput;
use \libAllure\ElementFile;
use \libAllure\ElementNumeric;
use \libAllure\ElementHidden;
use \libAllure\Sanitizer;
use \libAllure\ElementSelect;
use \libAllure\DatabaseFactory;

class FormEditLevel extends Form {
	public function __construct() {
		parent::__construct('formEditLevel', 'Edit level');

		$sanitizer = new Sanitizer();
		$levelId = $sanitizer->filterUint('level');
		$this->level = $this->getLevel($levelId);

		$this->addElement(new ElementInput('title', 'Title', $this->level['title']));
		$this->addElement(new ElementFile('imageUrl', 'Level image'));
		$this->getElement('imageUrl')->setDestination('resources/images/levels/', 'level' . $this->level['id'] . '.png');
		$this->getElement('imageUrl')->imageMaxW = 580;
		$this->getElement('imageUrl')->imageMaxH = 240;

		$this->addElement(new ElementNumeric('ordinal', 'Ordinal', $this->level['ordinal']));
		$this->addElement($this->getElementQuiz($this->level['quiz']));

		$this->addElement(new ElementHidden('level', null, $this->level['id']));
		$this->addDefaultButtons();
	}

	private function getElementQuiz($id) {
		$el = new ElementSelect('quiz', 'quiz', 'Quiz');

		$sql = 'SELECT q.id, q.title FROM quizes q';
		$stmt = DatabaseFactory::getInstance()->prepare($sql);
		$stmt->execute();

		foreach ($stmt->fetchAll() as $quiz) {
			$el->addOption($quiz['title'], $quiz['id']);
		}

		$el->setValue($id);

		return $el;
	}

	public function validateInternals() {
		$this->getElement('imageUrl')->validateImage();
	}

	private function getLevel($levelId) {
		global $db;

		$sql = 'SELECT l.id, l.title, l.quiz, l.ordinal FROM levels l WHERE l.id = :levelId ';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':levelId', $levelId);
		$stmt->execute();

		return $stmt->fetchRow();
	}

	public function process() {
		global $db;

		$sql = 'UPDATE levels SET title = :title, ordinal = :ordinal, quiz = :quiz WHERE id = :id';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':title', $this->getElementValue('title'));
		$stmt->bindValue(':ordinal', $this->getElementValue('ordinal'));
		$stmt->bindValue(':id', $this->level['id']);
		$stmt->bindValue(':quiz', $this->getElementValue('quiz'));
		$stmt->execute();

		$this->processImage();
	}

	private function processImage() {
		if ($this->getElement('imageUrl')->wasAnythingUploaded()) {
			$this->getElement('imageUrl')->savePng();
			$this->getElement('imageUrl')->destinationFilename;			
		}
	}

}

?>
