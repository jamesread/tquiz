<?php

use \libAllure\Form;
use \libAllure\ElementNumeric;
use \libAllure\ElementSelect;
use \libAllure\DatabaseFactory;

class FormTeamReset extends Form
{
    public function __construct()
    {
        parent::__construct('resetTeam', 'Reset team level');
        $this->addElement($this->getTeamSelectElement());
        $this->addelement(new ElementNumeric('toLevel', 'Level'));
        $this->addDefaultButtons();
    }

    public function getTeamSelectElement()
    {
        $el = new ElementSelect('teamId', 'Team');

        $sql = 'SELECT t.id, t.title FROM teams t';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $team) {
            $el->addOption($team['title'], $team['id']);
        }

        return $el;
    }

    public function process()
    {
        global $db;

        $sql = 'DELETE FROM team_progress WHERE team = :teamId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':teamId', $this->getElementValue('teamId'));
        $stmt->execute();

        redirect('admin.php', 'Team has had all levels reset.');
    }
}

?>
