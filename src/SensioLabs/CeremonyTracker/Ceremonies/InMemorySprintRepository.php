<?php

namespace SensioLabs\CeremonyTracker\Ceremonies;

use SensioLabs\Ceremonies\SprintRepositoryInterface;
use SensioLabs\Ceremonies\Sprint;
use SensioLabs\Ceremonies\Project;

class InMemorySprintRepository implements SprintRepositoryInterface
{
    private $sprints = [];

    public function save(Sprint $sprint)
    {
        $project = $sprint->getProject();

        if (!isset($this->sprints[$project->getName()])) {
            $this->sprints[$project->getName()] = [];
        }

        $this->sprints[$project->getName()][] = $sprint;
    }

    public function getProjectSprints(Project $project)
    {
        if (!isset($this->sprints[$project->getName()])) {
            return [];
        }

        return $this->sprints[$project->getName()];
    }
}
