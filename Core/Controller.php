<?php

namespace Core;

use Core\Request;

class Controller {

    private $request = null;

    public function __construct() {

    }

    public function router(Request $request) {
        return null;
    }

    public function getRequest() {
        return $this->request;
    }

    public function setRequest(Request $request) {
        $this->request = $request;
        return $this;
    }
}
