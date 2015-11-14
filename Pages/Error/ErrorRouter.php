<?php

namespace Pages\Error;

use Core\Router;
use Core\Request;
use Core\Response;

class ErrorRouter extends Router {
    private $controller = null;

    private function getController() {
        if (empty($this->controler)) {
            $this->controller = new ErrorController($this->request);
            $this->controller->setContainer($this->container);
        }

        return $this->controller;
    }

    public function check() {
        return null;
    }

    public function showErrorPage() {
        return $this->getController()->errorAction();
    }
}
