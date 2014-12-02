<?php

use \libAllure\Form;
use \libAllure\ElementInput;
use \libAllure\Session;

class FormQuestions extends Form {
	private $elementToQuestionIdLookup = array();
	private $levelId;
	private $teamId;
	
	public function __construct() {
		parent::__construct('questions', 'Questions');
	}

	public function setLevelId($levelId) {
		$this->levelId = $levelId;
	}

	public function setTeamId($teamId) {
		$this->teamId = $teamId;
	}

	public function addQuestion($questionId, $questionText, $imageUrl = null, $hintCount = 0) {
		$questionText = '<strong>Question ' . (count($this->elementToQuestionIdLookup) + 1) . '</strong>: ' . $questionText;

		$el = new ElementInput('question' . $questionId, $questionText);
		$el->setMinMaxLengths(0, 64);

		$this->addElement($el);
		$this->elementToQuestionIdLookup[$questionId] = $el;

		if (!empty($imageUrl)) {
			$el->description =  '<span class = "questionImage"><img src = "resources/images/questions/' . $imageUrl . '" alt = "imageForQuestion" /></span>';
		}

		if (Session::getUser()->hasPriv('EDIT_QUESTIONS')) {
			$el->description .= '<a href = "editQuestion.php?formEditQuestion-id=' . $questionId . '">Edit</a> ';
		}

		for ($i = 0; $i < $hintCount; $i++) {
//			$el->description .= '<a href = "#" onclick = "javascript:revealHintForQuestion(' . $questionId . ')">Reveal hint</a>';
		}
	}

	public function finishedAddingQuestions()	{
		$this->addDefaultButtons();
	}

	public function validateExtended() {
		foreach ($this->elementToQuestionIdLookup as $questionId => $element) {
			if ($element->getValue() == '') {
				$this->setElementError($this->getInternalElementName($element), 'No answer for this question!');
			} else {
				$this->validateQuestion($questionId, $element);				
			}
		}
	}

	public function validateQuestion($questionId, $element) {
		global $db;

		$sql = 'SELECT answer FROM questions WHERE id = :questionId';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':questionId', $questionId);
		$stmt->execute();

		$question = $stmt->fetchRow();

		$correctness = levenshtein(strtolower($question['answer']), strtolower($element->getValue()));

		if ($correctness == 0) {
			// correct!
			$element->description .= '<br /><br /><strong style = "color:green">Correct!</strong>';
		} else if ($correctness < 3) {
			$element->setValidationError('Nearly right! Try changing a few letters...');
		} else {
			$element->setValidationError('Wrong answer, try again!');
		}
	}

	private function getInternalElementName(\libAllure\Element $el) {
		return str_replace($this->getName() . '-', '', $el->getName());
	}

	public function process() {
		global $db;

		$sql = 'INSERT INTO team_progress (team, level, status) VALUES (:teamId, :level, 1) ON DUPLICATE KEY UPDATE status = 1';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':teamId', $this->teamId);
		$stmt->bindValue(':level', $this->levelId);
		$stmt->execute();
	}
}

?>
