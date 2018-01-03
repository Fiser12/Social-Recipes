<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\UserFacebookAccessToken;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserFacebookAccessTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('3jfhn3875efmeckme2');
        $this->shouldHaveType(UserFacebookAccessToken::class);
        $this->token()->shouldBe('3jfhn3875efmeckme2');
    }
}
