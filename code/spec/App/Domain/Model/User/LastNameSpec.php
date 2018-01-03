<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\LastName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LastNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('García');
        $this->shouldHaveType(LastName::class);
        $this->lastName()->shouldBe('García');
    }
}
