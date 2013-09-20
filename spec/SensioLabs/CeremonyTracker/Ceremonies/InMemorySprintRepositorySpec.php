<?php

namespace spec\SensioLabs\CeremonyTracker\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\Sprint;
use SensioLabs\Ceremonies\Project;

class InMemorySprintRepositorySpec extends ObjectBehavior
{
    function it_is_a_sprint_repository()
    {
        $this->shouldBeAnInstanceOf('SensioLabs\Ceremonies\SprintRepositoryInterface');
    }

    function it_stores_sprints_of_specific_projects(
        Sprint $sprint1,
        Sprint $sprint2,
        Project $project1,
        Project $project2
    )
    {
        $project1->getName()->willReturn('Nokia');
        $project2->getName()->willReturn('Siemens');

        $sprint1->getProject()->willReturn($project1);
        $sprint2->getProject()->willReturn($project2);

        $this->save($sprint1);
        $this->save($sprint2);

        $this->getProjectSprints($project1)->shouldReturn([$sprint1]);
        $this->getProjectSprints($project2)->shouldReturn([$sprint2]);
    }

    function it_returns_empty_array_if_project_has_no_sprints(Project $project)
    {
        $project->getName()->willReturn('Nokia');
        $this->getProjectSprints($project)->shouldReturn([]);
    }
}
