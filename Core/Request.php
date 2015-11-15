<?php

namespace Core;

class Request {

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

    function isPut() {
        return $_SERVER['REQUEST_METHOD'] === 'PUT';
    }

    function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    function isDelete() {
        return $_SERVER['REQUEST_METHOD'] === 'DELETE';
    }

    function getReferer() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }

    function isAjax() {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ;
    }
}
