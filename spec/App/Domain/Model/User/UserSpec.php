<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\FullName;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserFacebookAccessToken;
use App\Domain\Model\User\UserFacebookId;
use App\Domain\Model\User\UsersFollowed;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $facebookAccessToken,
        UsersFollowed $usersFollowed
    ){
        $this->beConstructedWith(new UserId("323"), $fullName, new UserEmail("fiser12@icloud.com"), null, $facebookId, $facebookAccessToken, $usersFollowed);
    }

    function it_have_correct_type()
    {
        $this->shouldHaveType(User::class);
    }
}
