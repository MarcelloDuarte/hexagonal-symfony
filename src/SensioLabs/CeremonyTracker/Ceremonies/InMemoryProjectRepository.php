<?php

namespace SensioLabs\CeremonyTracker\Ceremonies;

use SensioLabs\Ceremonies\ProjectRepositoryInterface;
use SensioLabs\Ceremonies\Project;
use SensioLabs\Ceremonies\ProjectManager;

class InMemoryProjectRepository implements ProjectRepositoryInterface
{
    private $projects = [];

    public function save(Project $project)
    {
        $manager = $project->getManager();

        if (!isset($this->projects[$manager->getName()])) {
            $this->projects[$manager->getName()] = [];
        }

        $this->projects[$manager->getName()][] = $project;
    }

    public function getManagerProjects(ProjectManager $manager)
    {
        if (!isset($this->projects[$manager->getName()])) {
            return [];
        }

        return $this->projects[$manager->getName()];
    }
}
