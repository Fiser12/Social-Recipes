<?php

namespace Spec\Recipes\Domain\Model\Session;

use Recipes\Domain\Model\Session\LastName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LastNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Botella');
    }

    function it_is_type()
    {
        $this->shouldHaveType(LastName::class);
    }

    function it_is_initializable()
    {
        $this->lastName()->shouldBe('Botella');
    }
}
