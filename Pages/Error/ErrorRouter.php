<?php

namespace Pages\Error;

use Core\Router;
use Core\Request;
use Core\Response;

class ErrorRouter extends Router {
    private $controller = null;

    private function getController() {
        if (empty($this->controler)) {
            $this->controller = new ErrorController();
            $this->controller->setContainer($this->container);
        }

        return $this->controller;
    }

    public function check() {

        $this->setRequest($this->request);

        return $this->getController()->errorAction();
    }
}
