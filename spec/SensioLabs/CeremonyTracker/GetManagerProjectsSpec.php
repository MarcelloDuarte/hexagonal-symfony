<?php

namespace spec\SensioLabs\CeremonyTracker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\ProjectRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use SensioLabs\Ceremonies\Project;
use SensioLabs\Ceremonies\ProjectManager;

class GetManagerProjectsSpec extends ObjectBehavior
{
    function let(ProjectRepositoryInterface $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_retrieves_manager_projects_using_repository(
        Project $project1,
        Project $project2,
        ProjectManager $manager,
        $repository
    )
    {
        $repository->getManagerProjects($manager)->willReturn([$project1, $project2]);

        $this->getManagerProjects($manager)->shouldReturn([$project1, $project2]);
    }
}
