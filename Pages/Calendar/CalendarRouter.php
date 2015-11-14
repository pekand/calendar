<?php

namespace Pages\Calendar;

use Core\Router;
use Core\Request;
use Core\Response;

class CalendarRouter extends Router {

    private $controller = null;

    private function getController() {
        if (empty($this->controler)) {
            return new CalendarController;
        }

        return $this->controller;
    }

    public function check() {

        $url = $this->request->getUrl();

        if(preg_match('/^$/', $url, $m))
        {
          return $this->getController()->indexAction();
        }

        if(preg_match('/^note\/edit\/([0-9]+)$/', $url, $m))
        {
          $note_id = intval($m[1]);

          return $this->getController()->editNoteAction($note_id);
        }

        return null;
    }
}
