<?php

namespace SensioLabs\CeremonyTracker;

use SensioLabs\Ceremonies\Project;
use SensioLabs\Ceremonies\ProjectRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProject
{
    const SUCCESS = 'sensio.ceremony_tracker.project_creation_success';
    const FAILURE = 'sensio.ceremony_tracker.project_creation_failure';

    private $repository;
    private $dispatcher;

    public function __construct(ProjectRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function createProject(Project $project)
    {
        if (!$project->getName()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'project' => $project,
                'reason'  => 'Project does not have a name.'
            ]));

            return;
        }

        $this->repository->save($project);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['project' => $project]));
    }
}
