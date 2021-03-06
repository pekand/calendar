<?php

namespace Core;

abstract class Router extends ContainerAware {

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
