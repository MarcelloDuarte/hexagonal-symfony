<?php

namespace spec\SensioLabs\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SensioLabs\Ceremonies\Ceremony;

class SpecificationSpec extends ObjectBehavior
{
    function let(Ceremony $ceremony1, Ceremony $ceremony2)
    {
        $this->beConstructedWith(15, [$ceremony1, $ceremony2]);
    }

    function it_has_a_sprint_length()
    {
        $this->getSprintLength()->shouldReturn(15);
    }

    function it_stores_list_of_predefined_ceremonies($ceremony1, $ceremony2)
    {
        $this->getCeremonies()->shouldReturn([$ceremony1, $ceremony2]);
    }
}
