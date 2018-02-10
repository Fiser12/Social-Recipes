<?php

namespace Spec\CompositeUi\Domain\Model\Session;

use CompositeUi\Domain\Model\Session\UserFacebookId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserFacebookIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('id');
    }

    function it_is_type()
    {
        $this->shouldHaveType(UserFacebookId::class);
    }

    function it_is_initializable()
    {
        $this->id()->shouldBe('id');
    }
}
