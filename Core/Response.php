<?php

namespace Core;

class Response {
    private $body = null;

    function __construct($body) {
        $this->body = $body;
    }

    function getBody() {
        return $this->body;
    }

    function setBody($body) {
        $this->body = $body;
        return $this;
    }

    function out() {
        echo $this->getBody();
    }
}
