<?php

use \libAllure\Form;
use \libAllure\DatabaseFactory;
use \libAllure\ElementInput;
use \libAllure\ElementHidden;
use \libAllure\Sanitizer;

class FormEditQuiz extends Form
{
    private $databaseRow = null;

    public function __construct($quizId)
    {
        parent::__construct('formEditQuiz', 'Edit Quiz');

        $this->loadQuiz($quizId);

        $this->addElement(new ElementInput('title', 'Title', $this->databaseRow['title']));
        $this->addElement(new ElementHidden('id', null, $this->databaseRow['id']));

        $this->addDefaultButtons();
    }

    private function loadQuiz($quizId)
    {
        $sql = 'SELECT q.id, q.title FROM quizes q WHERE q.id = :id  ';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->bindValue(':id', $quizId);
        $stmt->execute();

        if ($stmt->numRows() == 0) {
            throw new Exception('Could not find quiz');
        }

        $this->databaseRow = $stmt->fetchRow();
    }

    public function process()
    {
        $sanitizer = new Sanitizer();

        $sql = 'UPDATE quizes SET title = :title WHERE id = :id';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->bindValue(':title', $sanitizer->escapeStringForDatabase($this->getElementValue('title')));
        $stmt->bindValue(':id', $this->databaseRow['id']);
        $stmt->execute();
    }
}

?>
