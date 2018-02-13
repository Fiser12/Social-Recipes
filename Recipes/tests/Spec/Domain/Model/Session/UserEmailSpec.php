<?php

namespace Spec\Recipes\Domain\Model\Session;

use Recipes\Domain\Model\Session\UserEmail;
use Recipes\Domain\Model\Session\UserEmailInvalidException;
use PhpSpec\ObjectBehavior;

class UserEmailSpec extends ObjectBehavior
{
    function it_constructs_with_valid_email()
    {
        $this->beConstructedWith('bengor@user.com');
        $this->shouldHaveType(UserEmail::class);

        $this->email()->shouldBe('bengor@user.com');
        $this->domain()->shouldBe('user.com');
        $this->localPart()->shouldBe('bengor');
        $this->__toString()->shouldBe('bengor@user.com');
    }

    function it_constructs_with_invalid_email()
    {
        $this->beConstructedWith('invalid string');

        $this->shouldThrow(UserEmailInvalidException::class)->duringInstantiation();
    }

    function it_compares_ids()
    {
        $this->beConstructedWith('bengor@user.com');

        $this->equals(new UserEmail('bengor@user.com'))->shouldBe(true);
    }

    function it_compares_different_ids()
    {
        $this->beConstructedWith('bengor@user.com');

        $this->equals(new UserEmail('not-bengor@user.com'))->shouldBe(false);
    }
}
