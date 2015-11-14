<?php

namespace Pages\Calendar;

use Core\Service;

/*
    Calendar
*/
class CalendarManager extends Service
{
    public function loadEvents($start, $end)
    {
        $repository = $this->container->get('CalendarRepository');

        return $repository->loadEvents($start, $end);
    }

    public function getEvent($id)
    {
        $repository = $this->container->get('CalendarRepository');

        return $repository->getEvent($id);
    }

    public function insertEvent($start, $end, $title, $tags, $note, $allDay)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->insertEvent($start, $end, $title, $tags, $note, $allDay);
        return $repository->getEvent($id);
    }

    public function updateEvent($id, $start, $end, $title, $tags, $note, $allDay)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->updateEvent($id, $start, $end, $title, $tags, $note, $allDay);
        return $repository->getEvent($id);
    }

    public function deleteEvent($id)
    {
        $repository = $this->container->get('CalendarRepository');
        $repository->deleteEvent($id);
        return $id;
    }

    public function copyEvent($id, $delta)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->copyEvent($id, $delta);
        return $id;
    }

     public function moveEvent($id, $delta)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->moveEvent($id, $delta);
        return $id;
    }

    public function resizeEvent($id, $delta)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->resizeEvent($id, $delta);
        return $id;
    }
}
