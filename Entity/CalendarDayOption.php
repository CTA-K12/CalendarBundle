<?php

namespace MESD\Presentation\CalendarBundle\Entity;

class CalendarDayOption {
    private $options;
    private $date;

    public function __construct(\DateTime $date, $options = '') {
        $this->date = $date;
        $this->options = $options;
    }

    public function getDate() {
        return $this->date;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }
}