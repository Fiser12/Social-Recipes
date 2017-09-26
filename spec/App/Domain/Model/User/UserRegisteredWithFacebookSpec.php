<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\FullName;
use App\Domain\Model\User\UserFacebookAccessToken;
use App\Domain\Model\User\UserFacebookId;
use App\Domain\Model\User\UserRegisteredWithFacebook;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRegisteredWithFacebookSpec extends ObjectBehavior
{
    function it_is_initializable(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $facebookAccessToken
    )
    {
        $userEmail = new UserEmail("fiser12@icloud.com");
        $userId = new UserId(249382623);
        $this->beConstructedWith($userId, $fullName, $facebookId, $facebookAccessToken, $userEmail);
        $this->shouldHaveType(UserRegisteredWithFacebook::class);
        $this->email()->shouldBe($userEmail);
        $this->id()->shouldBe($userId);
        $this->facebookAccessToken()->shouldBe($facebookAccessToken);
        $this->fullName()->shouldBe($fullName);
    }
}
