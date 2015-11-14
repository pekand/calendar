<?php

namespace Core;

use Config\Config;

class WebPage {
    private $request = null;
    private $response = null;

    private $config = null;
    private $services = null;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->config = new Config();
        $this->services = new Services();
    }

    private function processServices() {
         // find services
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->config->pagespath
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($files as $name => $file) {
            if(preg_match("/^.+\/([^\/]+)\/([^\/]+)Services.php$/", $name, $m))
            {
                var_dump($m);
                //echo $name."<br/>";
                $className = 'Pages\\' . $m[1] .'\\' . $m[2]. 'Services';

                $services = new $className();
                if ($services instanceof ServiceContainer) {
                    $this->services->add($services);
                }
            }
        }
    }

    private function processRouters() {
        $response = null;
         // find route
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->config->pagespath
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($files as $name => $file) {
            if(preg_match("/^.+\/([^\/]+)\/([^\/]+)Router.php$/", $name, $m))
            {
                //var_dump($m);
                //echo $name."<br/>";
                $className = 'Pages\\' . $m[1] .'\\' . $m[2]. 'Router';

                $router = new $className($this->request);
                if ($router instanceof Router) {
                    $response = $router->check();
                }
            }
        }

        // novalid route found
        if (empty($response)) {
            $router = new \Pages\Error\ErrorRouter($this->request);
             $response = $router->check($this->request);
        }

        return $response;
    }

    public function render() {

        $this->processServices();
        $this->response = $this->processRouters();

        echo $this->response->out();
    }
}
