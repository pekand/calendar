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
                //var_dump($m);
                //echo $name."<br/>";
                $className = 'Pages\\' . $m[1] .'\\' . $m[2]. 'Services';

                $services = new $className();
                if ($services instanceof ServiceContainer) {
                    $services->setContainer($this->services);
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

        try {
            foreach ($files as $name => $file) {
                if(preg_match("/^.+\/([^\/]+)\/([^\/]+)Router.php$/", $name, $m))
                {
                    //var_dump($m);
                    //echo $name."<br/>";
                    $className = 'Pages\\' . $m[1] .'\\' . $m[2]. 'Router';

                    $router = new $className($this->request);
                    if ($router instanceof Router) {
                        $router->setContainer($this->services);
                        $response = $router->check();
                        if (!empty($response)) {
                            break;
                        }
                    }
                }
            }

            // novalid route found
            if (empty($response)) {
                $router = new \Pages\Error\ErrorRouter($this->request);
                $router->setContainer($this->services);
                $response = $router->showErrorPage();
            }

        } catch (AccessForbiddenException $e) {

            // remember url
            $this->services->get('Security')->setReferer(
                $this->request->getReferer()
            );

            // show login page
            $router = new \Pages\Login\LoginRouter($this->request);
            $router->setContainer($this->services);
            $response = $router->showLoginPage();
        }

        return $response;
    }

    public function render() {

        $this->processServices();
        $this->response = $this->processRouters();

        echo $this->response->out();
    }
}
