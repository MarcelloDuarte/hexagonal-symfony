<?php

namespace SensioLabs\Ceremonies;

use DateTime;

class Sprint
{
    protected $startDate;
    protected $length;
    protected $project;
    protected $ceremonies;

    public function __construct(DateTime $startDate, $length, Project $project)
    {
        $this->startDate = $startDate;
        $this->length = intval($length);
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getCeremonies()
    {
        return $this->ceremonies ?: [];
    }

    public function applySpecification(Specification $specification)
    {
        $this->ceremonies = $specification->getCeremonies();
    }
}
