<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\UsersFollowed;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsersFollowedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UsersFollowed::class);
    }
}
