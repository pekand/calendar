<?php

namespace Pages\Calendar;

use Core\Router;
use Core\Request;
use Core\Response;

class CalendarRouter extends Router {

    private $controller = null;

    private function getController() {
        if (empty($this->controler)) {
            $this->controller = new CalendarController();
            $this->controller->setContainer($this->container);
        }

        return $this->controller;
    }

    public function check() {

        $url = $this->request->getUrl();

        if(preg_match('/^$/', $url, $m))
        {
            $mode = "agendaWeek";
            $cdate = date('Y-m-d');
            return $this->getController()->indexAction($mode, $cdate);
        }

        if(preg_match('/^calendar\/(month|agendaWeek|agendaDay)\/(\d{4}-\d{2}-\d{2}|today)$/', $url, $m))
        {
            $mode = $m[1];
            $cdate = $m[2];

            if ($cdate == 'today') {
                $cdate = date('Y-m-d');
            }

            return $this->getController()->indexAction($mode, $cdate);
        }

        if(preg_match('/^calendar\/insert-event-form$/', $url, $m))
        {
            $start = $this->request->getParam('start');
            $end = $this->request->getParam('end');
            return $this->getController()->showInsertEventFormAction($start, $end);
        }

        if(preg_match('/^calendar\/edit-event-form$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            return $this->getController()->showEditEventFormAction($id);
        }

        if(preg_match('/^calendar\/load-events$/', $url, $m))
        {
            $start = $this->request->getParam('start');
            $end = $this->request->getParam('end');
            return $this->getController()->loadEventsAction($start, $end);
        }

        if(preg_match('/^calendar\/insert-event$/', $url, $m))
        {
            $start = $this->request->getParam('start');
            $end = $this->request->getParam('end');
            return $this->getController()->insertEventAction($start, $end);
        }

        return null;
    }
}
