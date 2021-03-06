<?php

namespace Pages\Calendar;

use Core\ServiceContainer;

class CalendarServices extends ServiceContainer {

    private $calendarManager = null;
    private $calendarRepository = null;
    private $eventValidator = null;

    public function getCalendarManagerService() {
        if (empty($this->calendarManager)) {
            $this->calendarManager = new \Pages\Calendar\CalendarManager();
            $this->calendarManager->setContainer($this->container);
        }

        return $this->calendarManager;
    }

    public function getCalendarRepositoryService() {
        if (empty($this->calendarRepository)) {
            $this->calendarRepository =  new \Pages\Calendar\CalendarRepository();
            $this->calendarRepository->setContainer($this->container);
        }

        return $this->calendarRepository;
    }

    public function getEventValidatorService() {
        if (empty($this->eventValidator)) {
            $this->eventValidator =  new \Pages\Calendar\EventValidator();
            $this->eventValidator->setContainer($this->container);
        }

        return $this->eventValidator;
    }

}
