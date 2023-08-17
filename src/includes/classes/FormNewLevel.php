<?php

use \libAllure\Form;
use \libAllure\ElementInput;
use \libAllure\ElementHidden;

class FormNewLevel extends Form
{
    public function __construct($quizId)
    {
        parent::__construct('newLevel', 'New level');

        $this->addElement(new ElementInput('title', 'Title'));
        $this->addElement(new ElementHidden('quiz', null, $quizId));

        $this->addDefaultButtons();
    }

    public function process()
    {
        global $db;

        $sql = 'INSERT INTO levels (quiz, title) VALUES (:quiz, :title) ';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':quiz', $this->getElementValue('quiz'));
        $stmt->bindValue(':title', $this->getElementValue('title'));
        $stmt->execute();
    }
}

?>
