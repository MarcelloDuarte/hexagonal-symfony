<?php

namespace SensioLabs\CeremonyTracker;

use SensioLabs\Ceremonies\ProjectRepositoryInterface;
use SensioLabs\Ceremonies\ProjectManager;

class GetManagerProjects
{
    private $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getManagerProjects(ProjectManager $manager)
    {
        return $this->repository->getManagerProjects($manager);
    }
}
