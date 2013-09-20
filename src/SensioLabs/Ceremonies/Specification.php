<?php

namespace SensioLabs\Ceremonies;

class Specification
{
    protected $sprintLength;
    protected $ceremonies;

    public function __construct($sprintLength, array $ceremonies)
    {
        $this->sprintLength = $sprintLength;
        $this->ceremonies = $ceremonies;
    }

    public function getSprintLength()
    {
        return $this->sprintLength;
    }

    public function getCeremonies()
    {
        return $this->ceremonies;
    }
}
