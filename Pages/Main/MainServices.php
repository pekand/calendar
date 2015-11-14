<?php

namespace Pages\Main;

use Core\ServiceContainer;

class MainServices extends ServiceContainer {

    private $database = null;
    private $template = null;

    public function getDatabaseService() {
        if (empty($this->database)) {
            return new\Core\Database();
        }

        return $this->database;
    }

    public function getTemplateService() {
        if (empty($this->template)) {
            return new\Core\Template();
        }

        return $this->template;
    }
}
