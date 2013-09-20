<?php

namespace spec\SensioLabs\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use SensioLabs\Ceremonies\ProjectManager;

class ProjectSpec extends ObjectBehavior
{
    function let(ProjectManager $manager)
    {
        $this->beConstructedWith('a project name', $manager);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('a project name');
    }

    function it_has_a_link_to_a_manager(ProjectManager $manager)
    {
        $this->getManager()->shouldReturn($manager);
    }
}
