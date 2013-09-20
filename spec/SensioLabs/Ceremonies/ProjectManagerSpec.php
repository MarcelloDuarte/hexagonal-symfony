<?php

namespace spec\SensioLabs\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProjectManagerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('a name');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('a name');
    }
}
