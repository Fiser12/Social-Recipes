<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\UserFacebookId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserFacebookIdSpec extends ObjectBehavior
{
    function it_is_initializable(UserFacebookId $id)
    {
        $this->beConstructedWith('3jfhn3875efmeckme2');
        $this->shouldHaveType(UserFacebookId::class);
        $this->id()->shouldBe('3jfhn3875efmeckme2');
        $id->id()->willReturn('3jfhn3875efmeckme2');
        $this->equals($id)->shouldBe(true);
    }
}
