<?php

namespace Pages\Login;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\JsonResponse;

class LoginController extends Controller {

    private $request = null;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function loginAction () {

        $response = null;

        $html = $this->container->get('Template')->render(
            'Login/Login'
        );

        return new Response($html);
    }

    public function registrationAction () {

        $response = null;

        $html = $this->container->get('Template')->render(
            'Login/Registration'
        );

        return new Response($html);;
    }
}
