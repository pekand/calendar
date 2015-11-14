<?php

namespace Pages\Calendar;

use Core\Controller;
use Core\Request;
use Core\Response;
use Core\JsonResponse;

class CalendarController extends Controller {

    public function indexAction ($mode, $cdate) {
        $html = $this->container->get('Template')->render(
            'Calendar/Calendar',
            array(
                  'mode' => $mode,
                  'cdate' => $cdate,
            )
        );

        return new Response($html);
    }

    public function showInsertEventFormAction ($start, $end) {

        $start =  @date_format(date_create(preg_replace('/\(.*\)/', '', $start)),"Y-m-d H:i:s");
        $end   =  @date_format(date_create(preg_replace('/\(.*\)/', '', $end)),"Y-m-d H:i:s");

        srand(floor(time() / (60*60*24)));

        $html = $this->container->get('Template')->render(
            'Calendar/InsertEventForm',
            array(
                  'start' => $start,
                  'end' => $end,
                  'uid' => "uid_".md5(uniqid().'_'.rand(100000,999999 )),
            )
        );

        return new Response($html);
    }

    public function showEditEventFormAction ($id) {
        srand(floor(time() / (60*60*24)));

        $html = $this->container->get('Template')->render(
            'Calendar/EditEventForm',
            array(
                'id' => $id,
                'uid' => "uid_".md5(uniqid().'_'.rand(100000,999999 )),
            )
        );

        return new Response($html);
    }

    public function loadEventsAction ($start, $end) {
        $data = $this->container->get('CalendarManager')->loadEvents($start, $end);

        return new JsonResponse($data);
    }

    public function insertEventAction ($start, $end) {
        $data = $this->container->get('CalendarManager')->insertEvent($start, $end);

        return new JsonResponse($data);
    }
}
