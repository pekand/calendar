<?php

namespace Pages\Login;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\JsonResponse;
use Core\RefreshResponse;
use Core\RedirectResponse;

class LoginController extends Controller {

    private $request = null;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function loginAction () {

        $html = $this->container->get('Template')->render(
            'Login/Login',
            array(
                  'error' => false,
                  'username' => ''
            )
        );

        return new Response($html);
    }

    public function registrationAction ($username, $password) {

        if ($this->request->isPost()) {
            $userId = $this->container->get('Security')->createUser($username, $password);
            if (!empty($userId)) {
                $this->container->get('Security')->forceLogin($userId, $username);
            }
            return new RedirectResponse('/');
        }

        $html = $this->container->get('Template')->render(
            'Login/Registration'
        );

        return new Response($html);
    }

    public function checkLoginAction ($username, $password) {

        $success = $this->container->get('Security')->login($username, $password);

        if ($this->request->isAjax()) {
            return new JsonResponse($success);
        }

        if ($success) {
            $referer = $this->container->get('Security')->getReferer();
            if (!empty($referer)) {
                return new RedirectResponse($referer);
            }

            return new RedirectResponse('/');
        }

        $html = $this->container->get('Template')->render(
            'Login/Login',
            array(
                  'error' => true,
                  'username' => $username
            )
        );

        return new Response($html);
    }

    public function logoutAction () {
        $this->container->get('Security')->logout();
        return new RedirectResponse('/');
    }
}
