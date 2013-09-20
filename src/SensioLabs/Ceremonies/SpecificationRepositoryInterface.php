<?php

namespace SensioLabs\Ceremonies;

interface SpecificationRepositoryInterface
{
    public function save(Specification $specification);
    public function getSpecificationForSprintLength($sprintLength);
}
