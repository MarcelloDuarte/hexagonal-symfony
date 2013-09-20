<?php

namespace spec\SensioLabs\CeremonyTracker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\SprintRepositoryInterface;
use SensioLabs\Ceremonies\Sprint;
use SensioLabs\Ceremonies\Project;

class GetProjectSprintsSpec extends ObjectBehavior
{
    function let(SprintRepositoryInterface $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_retrieves_project_sprints_using_repository(
        Sprint $sprint1,
        Sprint $sprint2,
        Project $project,
        $repository
    )
    {
        $repository->getProjectSprints($project)->willReturn([$sprint1, $sprint2]);

        $this->getProjectSprints($project)->shouldReturn([$sprint1, $sprint2]);
    }
}
