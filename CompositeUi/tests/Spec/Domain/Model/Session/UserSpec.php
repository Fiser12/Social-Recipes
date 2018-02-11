<?php

namespace Spec\CompositeUi\Domain\Model\Session;

use CompositeUi\Domain\Model\Session\FullName;
use CompositeUi\Domain\Model\Session\User;
use CompositeUi\Domain\Model\Session\UserEmail;
use PhpSpec\ObjectBehavior;
use CompositeUi\Domain\Model\Session\UserFacebookId;

class UserSpec extends ObjectBehavior
{
    function let(
        UserFacebookId $facebookId,
        UserEmail $userEmail,
        FullName $fullName
    )
    {
        $this->beConstructedWith(
            $facebookId,
            $userEmail,
            $fullName,
            'jwt'
        );
    }

    function it_is_type()
    {
        $this->shouldHaveType(User::class);
    }

    function it_is_initializable(
        UserFacebookId $facebookId,
        UserEmail $userEmail,
        FullName $fullName
    )
    {
        $this->fullName()->shouldBe($fullName);
        $this->facebookId()->shouldBe($facebookId);
        $this->email()->shouldBe($userEmail);
        $this->jwt()->shouldBe('jwt');
    }
}
