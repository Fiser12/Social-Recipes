<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\FirstName;
use LIN3S\SharedKernel\Exception\Exception;
use PhpSpec\ObjectBehavior;

class FirstNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Rubén');
        $this->shouldHaveType(FirstName::class);
        $this->firstName()->shouldBe('Rubén');
    }
    function it_isnt_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(Exception::class)->duringInstantiation();
    }
}
