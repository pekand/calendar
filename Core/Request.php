<?php

namespace Core;

class Request {
    private $url = null;

    function __construct() {
    }

    function getUrl() {
        return @$_REQUEST['u'];
    }

    function getParams() {
        return $_REQUEST;
    }

    function getParam($name) {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
    }

    function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    function isAjax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ;
    }
}
