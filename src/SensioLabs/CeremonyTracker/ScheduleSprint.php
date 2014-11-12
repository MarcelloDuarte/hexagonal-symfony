<?php

namespace SensioLabs\CeremonyTracker;

use SensioLabs\Ceremonies\SprintRepositoryInterface;
use SensioLabs\Ceremonies\SpecificationRepositoryInterface;
use SensioLabs\Ceremonies\Sprint;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ScheduleSprint
{
    const SUCCESS = 'sensio.ceremony_tracker.sprint_scheduling_success';
    const FAILURE = 'sensio.ceremony_tracker.sprint_scheduling_failure';

    private $sprintRepo;
    private $specRepo;
    private $dispatcher;

    public function __construct(SprintRepositoryInterface $sprintRepo, SpecificationRepositoryInterface $specRepo, EventDispatcherInterface $dispatcher)
    {
        $this->sprintRepo = $sprintRepo;
        $this->specRepo = $specRepo;
        $this->dispatcher = $dispatcher;
    }

    public function scheduleSprint(Sprint $sprint)
    {
        $specification = $this->specRepo->getSpecificationForSprintLength($sprint->getLength());
        if (!$specification) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'sprint' => $sprint,
                'reason' => 'No specification found for sprints with length = '.$sprint->getLength()
            ]));

            return;
        }

        $sprint->applySpecification($specification);
        $this->sprintRepo->save($sprint);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['sprint' => $sprint]));
    }
}
