<?php

namespace Core;

class Services {
    private $containers = array();

    public function __construct() {

    }

    public function add(ServiceContainer $serviceContainer) {
        $this->containers[] = $serviceContainer;
    }

    public function get($serviceName) {
        foreach($this->containers as $container) {
            $method = 'get' . $serviceName . 'Service';
            if (method_exists($container, $method)) {
                return $container->{$method};
            }
        }

        return null;
    }
}
