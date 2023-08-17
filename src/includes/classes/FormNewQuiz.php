<?php

use \libAllure\Form;
use \libAllure\ElementInput;
use \libAllure\DatabaseFactory;

class FormNewQuiz extends Form
{
    public function __construct()
    {
        parent::__construct('formNewQuiz', 'New Quiz');

        $this->addElement(new ElementInput('title', 'Title'));

        $this->addDefaultButtons('Create');
    }

    public function process()
    {
        $sql = 'INSERT INTO quizes (title) VALUES (:title) ';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->bindValue('title', $this->getElementValue('title'));
        $stmt->execute();
    }
}

?>
