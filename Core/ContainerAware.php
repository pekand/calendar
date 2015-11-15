<?php

namespace Core;

abstract class ContainerAware {
    public $container = null;

    public function setContainer(Services $services) {
        $this->container = $services;
    }
}
