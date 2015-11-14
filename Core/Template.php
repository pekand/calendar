<?php

namespace Core;

  /*
    GenerateTemplate
  */
  class Template extends Service
  {

    public function render($path, $params = array())
    {
        $template = $this;
        $config = $this->container->get('Config');
        extract($params);

        $templateFile = $config->pagespath . DIRECTORY_SEPARATOR . $path . "Template.php";
        if (file_exists($templateFile)) {
            ob_start();
            include $templateFile;
            return ob_get_clean();
        }

        return null;
    }
  }
