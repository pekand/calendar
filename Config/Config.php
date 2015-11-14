<?php

namespace Config;

class Config {

    public $dbanme = 'root';
    public $dbpassword = 'root';
    public $dbhost = '127.0.0.1';

    public $protocol;
    public $serverurl;
    public $serverpath;
    public $pagespath;

    function __construct() {
           $this->protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";
           $this->serverurl = $_SERVER['HTTP_HOST'];
           $this->serverpath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
           $this->pagespath = $this->serverpath . DIRECTORY_SEPARATOR . "Pages";
    }
}
