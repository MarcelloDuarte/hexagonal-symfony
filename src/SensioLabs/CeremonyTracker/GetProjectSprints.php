<?php

namespace SensioLabs\CeremonyTracker;

use SensioLabs\Ceremonies\SprintRepositoryInterface;
use SensioLabs\Ceremonies\Project;

class GetProjectSprints
{
    private $repository;

    public function __construct(SprintRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getProjectSprints(Project $project)
    {
        return $this->repository->getProjectSprints($project);
    }
}
