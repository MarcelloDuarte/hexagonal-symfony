<?php

namespace spec\SensioLabs\Ceremonies;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CeremonySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SensioLabs\Ceremonies\Ceremony');
    }
}
