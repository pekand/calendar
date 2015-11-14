<?php

namespace Pages\Error;

use Core\Controller;
use Core\Request;
use Core\Response;

class ErrorController extends Controller {

    public function errorAction () {
        return new Response("main");
    }
}
