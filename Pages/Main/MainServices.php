<?php

namespace Pages\Main;

use Core\ServiceContainer;

class MainServices extends ServiceContainer {

    private $config = null;
    private $database = null;
    private $template = null;

    public function getConfigService() {
        if (empty($this->config)) {
            $this->config =  new \Config\Config();
        }

        return $this->config;
    }

    public function getDatabaseService() {
        if (empty($this->database)) {
            $config = $this->container->get('Config');
            $this->database =  new \Core\Database($config->dbanme, $config->dbuser, $config->dbpassword, $config->dbhost);
        }

        return $this->database;
    }

    public function getTemplateService() {
        if (empty($this->template)) {
            $this->template =  new \Core\Template();
            $this->template->setContainer($this->container);
        }

        return $this->template;
    }
}
