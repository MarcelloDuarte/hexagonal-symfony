<?php

namespace spec\SensioLabs\CeremonyTracker\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\Specification;

class InMemorySpecificationRepositorySpec extends ObjectBehavior
{
    function it_is_a_specification_repository()
    {
        $this->shouldBeAnInstanceOf('SensioLabs\Ceremonies\SpecificationRepositoryInterface');
    }

    function it_stores_sprint_specifications(Specification $spec1, Specification $spec2)
    {
        $spec1->getSprintLength()->willReturn(10);
        $spec2->getSprintLength()->willReturn(15);

        $this->save($spec1);
        $this->save($spec2);

        $this->getSpecificationForSprintLength(10)->shouldReturn($spec1);
        $this->getSpecificationForSprintLength(15)->shouldReturn($spec2);
    }

    function it_returns_null_if_specification_for_provided_length_not_found()
    {
        $this->getSpecificationForSprintLength(5)->shouldReturn(null);
    }
}
