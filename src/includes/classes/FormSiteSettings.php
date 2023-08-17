<?php

use \libAllure\Form;
use \libAllure\DatabaseFactory;
use \libAllure\ElementInput;

class FormSiteSettings extends Form
{
    public function __construct()
    {
        parent::__construct('formSiteSettings', 'Site Settings');

        foreach ($this->getSettings() as $setting) {
            $el = $this->addElement(new ElementInput($setting['key'], $setting['key'], $setting['value']));
            $el->setMinMaxLengths(0, 128);

            if (!empty($setting['description'])) {
                $el->description = $setting['description'];
            }
        }

        $this->addDefaultButtons('Save settings');
    }

    public function getSettings()
    {
        $sql = 'SELECT `key`, value, description FROM site_settings ';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function process()
    {
        $sql = 'UPDATE site_settings SET value = :value WHERE `key` = :key';
        $stmt = DatabaseFactory::getInstance()->prepare($sql);

        foreach ($this->getSettings() as $setting) {
            $stmt->bindValue(':key', $setting['key']);
            $stmt->bindValue(':value', $this->getElementValue($setting['key']));
            $stmt->execute();
        }
    }
}

?>
