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
        $user = $this->container->get('Security')->getUser();
        $repository = $this->container->get('CalendarRepository');

        return $repository->loadEvents($start, $end, $user['id']);
    }

    public function getEvent($id)
    {
        $repository = $this->container->get('CalendarRepository');

        return $repository->getEvent($id);
    }

    public function insertEvent($start, $end, $title, $tags, $note, $allDay, $repeatEvent)
    {
        $user = $this->container->get('Security')->getUser();
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->insertEvent($user['id'], $start, $end, $title, $tags, $note, $allDay, $repeatEvent);
        return $repository->getEvent($id);
    }

    public function updateEvent($id, $start, $end, $title, $tags, $note, $allDay, $repeatEvent)
    {
        $user = $this->container->get('Security')->getUser();
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->updateEvent($id, $user['id'], $start, $end, $title, $tags, $note, $allDay, $repeatEvent);
        return $repository->getEvent($id);
    }

    public function deleteEvent($id)
    {
        $repository = $this->container->get('CalendarRepository');
        $repository->deleteEvent($id);
        return $id;
    }

    public function copyEvent($id, $delta, $allDay)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->copyEvent($id, $delta, $allDay);
        return $id;
    }

     public function moveEvent($id, $delta, $allDay)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->moveEvent($id, $delta, $allDay);
        return $id;
    }

    public function resizeEvent($id, $delta)
    {
        $repository = $this->container->get('CalendarRepository');
        $id = $repository->resizeEvent($id, $delta);
        return $id;
    }
}
