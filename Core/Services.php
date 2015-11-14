<?php

namespace Core;

class Services {
    private $containers = array();
    private $services = array();

    public function add(ServiceContainer $serviceContainer) {
        $this->containers[] = $serviceContainer;
    }

    public function get($serviceName) {
        if (isset($this->services[$serviceName])) {
            return $this->services[$serviceName];
        }

        foreach($this->containers as $container) {
            $method = 'get' . $serviceName . 'Service';
            if (method_exists($container, $method)) {
                $this->services[$serviceName] = $container->{$method}();
                return $this->services[$serviceName];
            }
        }

        return null;
    }
}
