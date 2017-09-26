<?php

namespace spec\App\Domain\Model\User;

use App\Domain\Model\User\FirstName;
use App\Domain\Model\User\FullName;
use App\Domain\Model\User\LastName;
use PhpSpec\ObjectBehavior;

class FullNameSpec extends ObjectBehavior
{
    function it_is_initializable(FirstName $firstName, LastName $lastName)
    {
        $this->beConstructedWith($firstName, $lastName);
        $this->shouldHaveType(FullName::class);
        $this->firstName()->shouldBe($firstName);
        $this->lastName()->shouldBe($lastName);
    }
}
