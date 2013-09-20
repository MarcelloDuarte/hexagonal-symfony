<?php

namespace SensioLabs\CeremonyTracker;

use SensioLabs\Ceremonies\SpecificationRepositoryInterface;
use SensioLabs\Ceremonies\Specification;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateSpecification
{
    const SUCCESS = 'sensio.ceremony_tracker.specification_creation_success';
    const FAILURE = 'sensio.ceremony_tracker.specification_creation_failure';

    private $repository;
    private $dispatcher;

    public function __construct(SpecificationRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function createSpecification(Specification $specification)
    {
        if (!$specification->getSprintLength()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'specification' => $specification,
                'reason'        => 'Specification does not have a length.'
            ]));

            return;
        }

        if (!count($specification->getCeremonies())) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'specification' => $specification,
                'reason'        => 'Specification does not have ceremonies.'
            ]));

            return;
        }

        $this->repository->save($specification);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['specification' => $specification]));
    }
}
