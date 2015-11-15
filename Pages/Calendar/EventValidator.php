<?php

namespace Pages\Calendar;

use Core\Validator;

/*
    Event form validator
*/
class EventValidator extends Validator
{
    public function isCurrentUserOwner($errorMessage = "Username already exists.") {
        $value = $this->getValue('id');

        if (empty($value)) {
            return true;
        }

        $repository = $this->container->get('CalendarRepository');
        $event = $repository->getEvent($value);
        $user = $this->container->get('Security')->getUser();

        if (!empty($user) || !empty($event) || $user['id'] != $event['id']) {
            $this->addError($paramName, $errorMessage);
            $this->valid = false;
            return false;
        }

        return true;
    }

    function check($group = "") {
            if ($group=="insert" || $group=="update") {
                $this->isDateTime('start');
                $this->isDateTime('end');
            }
            if ($group=="move") {
                $this->isInteger('delta');
            }
            $this->isCurrentUserOwner();
    }
}
