<?php

namespace SensioLabs\Ceremonies;

interface SprintRepositoryInterface
{
    public function save(Sprint $sprint);
    public function getProjectSprints(Project $project);
}
