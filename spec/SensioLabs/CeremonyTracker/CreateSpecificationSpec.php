<?php

namespace spec\SensioLabs\CeremonyTracker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\SpecificationRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SensioLabs\Ceremonies\Specification;

class CreateSpecificationSpec extends ObjectBehavior
{
    function let(SpecificationRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($repository, $dispatcher);
    }

    function it_saves_a_specification(Specification $specification, $repository)
    {
        $specification->getSprintLength()->willReturn(10);
        $specification->getCeremonies()->willReturn([1, 2]);

        $repository->save($specification)->shouldBeCalled();

        $this->createSpecification($specification);
    }

    function it_reports_success_to_the_dispatcher(Specification $specification, $dispatcher)
    {
        $specification->getSprintLength()->willReturn(10);
        $specification->getCeremonies()->willReturn([1, 2]);

        $dispatcher->dispatch($this->SUCCESS, Argument::any())->shouldBeCalled();

        $this->createSpecification($specification);
    }

    function it_does_not_save_a_zero_length_specification(Specification $specification, $repository)
    {
        $specification->getSprintLength()->willReturn(0);
        $specification->getCeremonies()->willReturn([1, 2]);

        $repository->save($specification)->shouldNotBeCalled();

        $this->createSpecification($specification);
    }

    function it_does_not_save_a_zero_ceremonies_specification(Specification $specification, $repository)
    {
        $specification->getSprintLength()->willReturn(10);
        $specification->getCeremonies()->willReturn([]);

        $repository->save($specification)->shouldNotBeCalled();

        $this->createSpecification($specification);
    }

    function it_reports_failure_to_the_dispatcher(Specification $specification, $dispatcher)
    {
        $specification->getSprintLength()->willReturn(0);

        $dispatcher->dispatch($this->FAILURE, Argument::any())->shouldBeCalled();

        $this->createSpecification($specification);
    }
}
