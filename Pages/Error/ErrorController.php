<?php

namespace Pages\Error;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\JsonResponse;

class ErrorController extends Controller {

    private $request = null;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function errorAction () {

        $response = null;

        if ($this->request->isAjax()) {
            $response = new JsonResponse(array('error'=>'Page not found'));
        } else {
            $html = $this->container->get('Template')->render(
                'Error/Error'
            );

            $response = new Response($html);
        }

        return $response;
    }
}
