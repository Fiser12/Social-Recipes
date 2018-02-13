<?php

namespace Spec\Recipes\Domain\Model\Session;

use Recipes\Domain\Model\Session\FirstName;
use Recipes\Domain\Model\Session\FullName;
use Recipes\Domain\Model\Session\LastName;
use PhpSpec\ObjectBehavior;

class FullNameSpec extends ObjectBehavior
{
    function let(FirstName $firstName, LastName $lastName)
    {
        $this->beConstructedWith($firstName, $lastName);
    }

    function it_is_type()
    {
        $this->shouldHaveType(FullName::class);
    }

    function it_is_initializable(FirstName $firstName, LastName $lastName)
    {
        $this->firstName()->shouldBe($firstName);
        $this->lastName()->shouldBe($lastName);
    }
}
