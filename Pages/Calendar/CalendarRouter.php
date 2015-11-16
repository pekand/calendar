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
            $title = $this->request->getParam('title');
            $tags = $this->request->getParam('tags');
            $note = $this->request->getParam('note');
            $allDay = $this->request->getParam('allDay');
            $repeatEvent = $this->request->getParam('repeatEvent');
            return $this->getController()->insertEventAction($start, $end, $title, $tags, $note, $allDay, $repeatEvent);
        }

        if(preg_match('/^calendar\/save-event$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            $start = $this->request->getParam('start');
            $end = $this->request->getParam('end');
            $title = $this->request->getParam('title');
            $tags = $this->request->getParam('tags');
            $note = $this->request->getParam('note');
            $allDay = $this->request->getParam('allDay');
            $repeatEvent = $this->request->getParam('repeatEvent');
            return $this->getController()->updateEventAction($id, $start, $end, $title, $tags, $note, $allDay, $repeatEvent);
        }

        if(preg_match('/^calendar\/move-event$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            $delta = $this->request->getParam('delta');
            $allDay = $this->request->getParam('allDay');
            return $this->getController()->moveEventAction($id, $delta, $allDay);
        }

        if(preg_match('/^calendar\/resize-event$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            $delta = $this->request->getParam('delta');
            return $this->getController()->resizeEventAction($id, $delta);
        }

        if(preg_match('/^calendar\/copy-event$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            $delta = $this->request->getParam('delta');
            $allDay = $this->request->getParam('allDay');
            return $this->getController()->copyEventAction($id, $delta, $allDay);
        }

        if(preg_match('/^calendar\/delete-event$/', $url, $m))
        {
            $id = $this->request->getParam('id');
            return $this->getController()->deleteEventAction($id);
        }

        return null;
    }
}
