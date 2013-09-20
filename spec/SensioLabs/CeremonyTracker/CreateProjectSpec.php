<?php

namespace spec\SensioLabs\CeremonyTracker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\ProjectRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SensioLabs\Ceremonies\Project;

class CreateProjectSpec extends ObjectBehavior
{
    function let(ProjectRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($repository, $dispatcher);
    }

    function it_saves_a_named_project_to_the_repository(Project $project, $repository)
    {
        $project->getName()->willReturn('Nokia');

        $repository->save($project)->shouldBeCalled();

        $this->createProject($project);
    }

    function it_reports_success_to_the_dispatcher(Project $project, $dispatcher)
    {
        $project->getName()->willReturn('Nokia');

        $dispatcher->dispatch($this->SUCCESS, Argument::any())->shouldBeCalled();

        $this->createProject($project);
    }

    function it_does_not_save_an_unnamed_project(Project $project, $repository)
    {
        $repository->save($project)->shouldNotBeCalled();

        $this->createProject($project);
    }

    function it_reports_failure_to_the_dispatcher(Project $project, $dispatcher)
    {
        $dispatcher->dispatch($this->FAILURE, Argument::any())->shouldBeCalled();

        $this->createProject($project);
    }
}
