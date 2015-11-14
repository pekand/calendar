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

    public function insertEvent($start, $end)
    {
        $repository = $this->container->get('CalendarRepository');

        return $repository->insertEvent($start, $end);
    }
}
