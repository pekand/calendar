<?php

namespace Core;

  /*
    GenerateTemplate
  */
  class Template extends Service
  {

    private $config = null;

    public function __construct() {

    }

    public function render($path, $params = array())
    {
        $this->config = $this->container->get('Config');

        if (file_exists($path)) {

        }

        return null;
    }
  }
