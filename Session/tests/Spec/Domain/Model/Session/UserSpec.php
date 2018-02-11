<?php

namespace Spec\Session\Domain\Model\Session;

use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Session\Domain\Model\Session\FullName;
use Session\Domain\Model\Session\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UsersFollowed;

class UserSpec extends ObjectBehavior
{
    function let(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $accessToken,
        UsersFollowed $usersFollowed
    )
    {
        $this->beConstructedSignUpWithFacebook(
            new UserId(),
            $fullName,
            $facebookId,
            new UserEmail('email@email.com'),
            $accessToken,
            $usersFollowed
        );
    }

    function it_is_type()
    {
        $this->shouldHaveType(User::class);
    }

    function it_is_initializable(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $accessToken,
        UsersFollowed $usersFollowed
    )
    {
        $this->fullName()->shouldBe($fullName);
        $this->facebookId()->shouldBe($facebookId);
        $this->facebookAccessToken()->shouldBe($accessToken);
        $this->usersFollowed()->shouldBe($usersFollowed);
    }
}
