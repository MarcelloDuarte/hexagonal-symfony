<?php

namespace SensioLabs\CeremonyTracker\Ceremonies;

use SensioLabs\Ceremonies\SpecificationRepositoryInterface;
use SensioLabs\Ceremonies\Specification;

class InMemorySpecificationRepository implements SpecificationRepositoryInterface
{
    private $specifications = [];

    public function save(Specification $specification)
    {
        $this->specifications[$specification->getSprintLength()] = $specification;
    }

    public function getSpecificationForSprintLength($sprintLength)
    {
        if (isset($this->specifications[$sprintLength])) {
            return $this->specifications[$sprintLength];
        }
    }
}
