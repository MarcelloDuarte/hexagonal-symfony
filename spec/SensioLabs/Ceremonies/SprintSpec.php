<?php

namespace spec\SensioLabs\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\Project;
use SensioLabs\Ceremonies\Ceremony;
use SensioLabs\Ceremonies\Specification;

class SprintSpec extends ObjectBehavior
{
    function let(Project $project)
    {
        $this->beConstructedWith(new \DateTime('19.01.1988'), 10, $project);
    }

    function it_has_a_link_to_a_project(Project $project)
    {
        $this->getProject()->shouldReturn($project);
    }

    function it_has_a_start_date()
    {
        $startDate = $this->getStartDate();
        $startDate->shouldBeAnInstanceOf('DateTime');
        $startDate->format('d.m.Y')->shouldReturn('19.01.1988');
    }

    function it_has_a_length()
    {
        $this->getLength()->shouldReturn(10);
    }

    function it_has_no_ceremonies_by_default()
    {
        $this->getCeremonies()->shouldReturn([]);
    }

    function it_can_apply_specification(Specification $spec, Ceremony $ceremony1, Ceremony $ceremony2)
    {
        $spec->getCeremonies()->willReturn([$ceremony1, $ceremony2]);

        $this->applySpecification($spec);

        $this->getCeremonies()->shouldReturn([$ceremony1, $ceremony2]);
    }
}
