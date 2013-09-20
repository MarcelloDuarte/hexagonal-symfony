<?php

namespace spec\SensioLabs\CeremonyTracker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\SprintRepositoryInterface;
use SensioLabs\Ceremonies\SpecificationRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SensioLabs\Ceremonies\Sprint;
use SensioLabs\Ceremonies\Specification;
use SensioLabs\Ceremonies\Ceremony;

class ScheduleSprintSpec extends ObjectBehavior
{
    function let(
        SprintRepositoryInterface $projectRepo,
        SpecificationRepositoryInterface $specRepo,
        EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($projectRepo, $specRepo, $dispatcher);
    }

    function it_saves_a_sprint_to_repository(Sprint $sprint, Specification $spec, $projectRepo, $specRepo)
    {
        $sprint->getLength()->willReturn(10);
        $specRepo->getSpecificationForSprintLength(10)->willReturn($spec);

        $sprint->applySpecification($spec)->shouldBeCalled();
        $projectRepo->save($sprint)->shouldBeCalled();

        $this->scheduleSprint($sprint);
    }

    function it_autochedules_sprint_ceremonies_using_specification(
        Sprint $sprint,
        Specification $spec,
        $specRepo
    )
    {
        $sprint->getLength()->willReturn(10);
        $specRepo->getSpecificationForSprintLength(10)->willReturn($spec);

        $sprint->applySpecification($spec)->shouldBeCalled();

        $this->scheduleSprint($sprint);
    }

    function it_reports_success_to_the_dispatcher(Sprint $sprint, Specification $spec, $specRepo, $dispatcher)
    {
        $sprint->getLength()->willReturn(10);
        $specRepo->getSpecificationForSprintLength(10)->willReturn($spec);

        $sprint->applySpecification($spec)->shouldBeCalled();
        $dispatcher->dispatch($this->SUCCESS, Argument::any())->shouldBeCalled();

        $this->scheduleSprint($sprint);
    }

    function it_does_not_save_a_zero_length_sprints(Sprint $sprint, $projectRepo)
    {
        $sprint->getLength()->willReturn(0);

        $projectRepo->save($sprint)->shouldNotBeCalled();

        $this->scheduleSprint($sprint);
    }

    function it_does_not_save_a_sprint_if_there_is_no_specification_for_its_length(Sprint $sprint, $projectRepo)
    {
        $sprint->getLength()->willReturn(10);

        $projectRepo->save($sprint)->shouldNotBeCalled();

        $this->scheduleSprint($sprint);
    }

    function it_reports_failure_to_the_dispatcher(Sprint $sprint, $dispatcher)
    {
        $sprint->getLength()->willReturn(0);

        $dispatcher->dispatch($this->FAILURE, Argument::any())->shouldBeCalled();

        $this->scheduleSprint($sprint);
    }
}
