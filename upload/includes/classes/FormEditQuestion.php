<?php

use \libAllure\Form;
use \libAllure\ElementHidden;
use \libAllure\ElementFile;
use \libAllure\ElementTextbox;
use \libAllure\ElementSelect;
use \libAllure\ElementInput;
use \libAllure\ElementCheckbox;

class FormEditQuestion extends Form {
	public function __construct($id) {
		parent::__construct('formEditQuestion', 'Edit question');

		global $db;

		$sql = 'SELECT q.id, q.question, q.level, q.answer, q.imageUrl, q.hint1 FROM questions q WHERE q.id = :id ';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();

		$this->question = $stmt->fetchRow();

		if (empty($this->question)) {
			throw new Exception('question not found:' . $id);
		}

		$this->addElement(new ElementHidden('id', null, $id));
		$this->addElement(new ElementTextbox('question', 'Question', $this->question['question']));
		$this->addElement($this->getElementLevel());
		$this->addElement(new ElementInput('answer', 'Answer', $this->question['answer']));
		$this->getElement('answer')->setMinMaxLengths(1, 64);
		$this->addElement(new ElementFile('imageUrl', 'Image URL', $this->question['imageUrl']));
		$this->getElement('imageUrl')->setDestination('resources/images/questions/', uniqid() . '.png');
		$this->getElement('imageUrl')->imageMaxW = 800;
		$this->getElement('imageUrl')->imageMaxH = 600;

		$this->addElement(new ElementInput('hints', 'Hints', $this->question['hint1']));
		$this->getElement('hints')->setMinMaxLengths(0, 128);

		$this->addElement(new ElementCheckbox('delete', 'Delete'));
		$this->addDefaultButtons();
	}

	private function getElementLevel() {
		global $db;

		$sql = 'SELECT l.id, l.quiz, l.title, q.title AS quizTitle FROM levels l JOIN quizes q ON l.quiz = q.id ORDER BY q.id ASC, l.title ASC';
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$el = new ElementSelect('level', 'Level', $this->question['level']);

		foreach ($stmt->fetchAll() as $level) {
			$title = $level['quizTitle'] . ' :: ' . $level['title'];

			if ($level['quiz'] == ACTIVE_QUIZ) {
				$title = '&raquo; ' . $title;
			}

			$el->addOption($title, $level['id']);
		}

		return $el;
	}

	private function processImage() {
		if ($this->getElement('imageUrl')->wasAnythingUploaded()) {
			$this->getElement('imageUrl')->savePng();
			$this->imageUrl = $this->getElement('imageUrl')->destinationFilename;			
		} else {
			$this->imageUrl = $this->question['imageUrl'];
		}
	}

	public function process() {
		global $db;

		if ($this->getElementValue('delete')) {
			requirePrivOrRedirect('SUPERUSER', 'index.php');

			$sql = 'DELETE FROM questions WHERE id = :questionId';
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':questionId', $this->getElementValue('id'));
			$stmt->execute();
			return;
		}

		$this->processImage();

		$sql = 'UPDATE questions SET question = :question, level = :level, answer = :answer, imageUrl = :imageUrl, hint1 = :hint WHERE id = :id ';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':question', $db->escape($this->getElementValue('question')));
		$stmt->bindValue(':level', $this->getElementValue('level'));
		$stmt->bindValue(':answer', $this->getElementValue('answer'));
		$stmt->bindValue(':imageUrl', $this->imageUrl);
		$stmt->bindValue(':hint', $this->getElementValue('hints'));
		$stmt->bindValue(':id', $this->getElementValue('id'));
		$stmt->execute();

		$sql = 'SELECT q.id FROM quizes q JOIN levels l ON l.id = :id';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $this->getElementValue('id'));
		$stmt->execute();

		$this->quiz = $stmt->fetchRow();
	}
}

?>
