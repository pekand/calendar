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
            $username = $this->request->getParam('username');
            $password = $this->request->getParam('password');
            return $this->getController()->loginAction($username, $password);
        }

        if(preg_match('/^registration$/', $url, $m))
        {
            $username = $this->request->getParam('username');
            $password = $this->request->getParam('password');
            $password_confirmation = $this->request->getParam('password_confirmation');
            return $this->getController()->registrationAction($username, $password, $password_confirmation);
        }

        if(preg_match('/^logout/', $url, $m))
        {
            return $this->getController()->logoutAction();
        }

        return null;
    }

    public function showLoginPage() {
        return $this->getController()->loginAction("", "");
    }
}
