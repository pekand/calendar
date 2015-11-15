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

    public function loginAction ($username, $password) {

        $form = $this->container->get('LoginValidator');
        $form->setParams(
            array(
                  'username' => $username,
                  'password' => $password,
            )
        );

        if ($this->request->isPost()) {
            if ($form->validate()) {
                $success = $this->container->get('Security')->login($username, $password);

                 if ($success) {
                    $referer = $this->container->get('Security')->getReferer();
                    if (!empty($referer)) {
                        return new RedirectResponse($referer);
                    }

                    return new RedirectResponse('/');
                }
            }
        }

        $html = $this->container->get('Template')->render(
            'Login/Login',
            array(
                  'form' => $form,
            )
        );

        return new Response($html);
    }

    public function registrationAction ($username, $password, $password_confirmation) {

        $form = $this->container->get('RegistrationValidator');
        $form->setParams(
            array(
                  'username' => $username,
                  'password' => $password,
                  'password_confirmation' => $password_confirmation,
            )
        );

        if ($this->request->isPost()) {
            if ($form->validate()) {
                $userId = $this->container->get('Security')->createUser($username, $password);
                if (!empty($userId)) {
                    $this->container->get('Security')->forceLogin($userId, $username);
                }
                return new RedirectResponse('/');
            }
        }

        $html = $this->container->get('Template')->render(
            'Login/Registration',
            array(
                  'form' => $form,
            )
        );

        return new Response($html);
    }

    public function logoutAction () {
        $this->container->get('Security')->logout();
        return new RedirectResponse('/');
    }
}
