<?php

namespace spec\SensioLabs\CeremonyTracker\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\Project;
use SensioLabs\Ceremonies\ProjectManager;

class InMemoryProjectRepositorySpec extends ObjectBehavior
{
    function it_is_a_project_repository()
    {
        $this->shouldBeAnInstanceOf('SensioLabs\Ceremonies\ProjectRepositoryInterface');
    }

    function it_stores_projects_of_specific_managers(
        Project $project1,
        Project $project2,
        ProjectManager $manager1,
        ProjectManager $manager2
    )
    {
        $manager1->getName()->willReturn('everzet');
        $manager2->getName()->willReturn('_md');

        $project1->getManager()->willReturn($manager1);
        $project2->getManager()->willReturn($manager2);

        $this->save($project1);
        $this->save($project2);

        $this->getManagerProjects($manager1)->shouldReturn([$project1]);
        $this->getManagerProjects($manager2)->shouldReturn([$project2]);
    }

    function it_returns_empty_array_if_manager_has_no_saved_projects(ProjectManager $manager)
    {
        $manager->getName()->willReturn('everzet');
        $this->getManagerProjects($manager)->shouldReturn([]);
    }
}
