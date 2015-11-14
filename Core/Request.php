<?php

namespace Core;

class Request {
    private $url = null;

    function __construct($url) {
        $this->url = $url;
    }

    function getUrl() {
        return $this->url;
    }

    function setUrl() {
        $this->url = $url;
        return $this;
    }
}