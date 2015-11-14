<?php

namespace Pages\Error;

use Core\Controller;
use Core\Request;
use Core\Response;

class ErrorController extends Controller {

    public function errorAction () {

        $html = $this->container->get('Template')->render(
            'Error\\Error',
            array(
                  'error' => '123'
            )
        );

        return new Response($html);
    }
}
