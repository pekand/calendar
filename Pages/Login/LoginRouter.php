<?php

namespace Pages\Login;

use Core\Router;
use Core\Request;
use Core\Response;

class LoginRouter extends Router {
    private $controller = null;

    private function getController() {
        if (empty($this->controler)) {
            $this->controller = new LoginController($this->request);
            $this->controller->setContainer($this->container);
        }

        return $this->controller;
    }

    public function check() {

        $url = $this->request->getUrl();

        if(preg_match('/^login$/', $url, $m))
        {
            return $this->getController()->loginAction();
        }

        if(preg_match('/^registration$/', $url, $m))
        {
            return $this->getController()->registrationAction();
        }

        return null;
    }

    public function showLoginPage() {
        return $this->getController()->indexAction();
    }
}
