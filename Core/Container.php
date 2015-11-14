<?php

namespace Core;

abstract class Container {
    public $container = null;

    public function setContainer(Services $services) {
        $this->container = $services;
    }
}
