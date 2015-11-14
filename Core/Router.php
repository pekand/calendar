<?php

namespace Core;

class Router {
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function setRequest(Request $request) {
        $this->request = $request;
        return $this;
    }

    public function getRequest() {
        return $this->request;
    }
}