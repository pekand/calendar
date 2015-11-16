<?php

namespace Pages\Calendar;

use Core\Validator;

/*
    Event form validator
*/
class EventValidator extends Validator
{
    function check($group = "") {
        if ($group=="insert" || $group=="update") {
            $this->isDateTime('start');
            $this->isDateTime('end');
            $this->isInInterval('repeatEvent', 0, 3);
        }
        if ($group=="move") {
            $this->isInteger('delta');
        }
    }
}
