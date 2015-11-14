<?php

namespace Pages\Calendar;

use Core\Controller;
use Core\Request;
use Core\Response;

class CalendarController extends Controller {

    public function indexAction () {
        return new Response("main");
    }

    public function editNoteAction () {
        return new Response("xxx");
    }
}
