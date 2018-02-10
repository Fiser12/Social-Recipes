<?php

namespace Spec\CompositeUi\Domain\Model\Session;

use CompositeUi\Domain\Model\Session\FirstName;
use CompositeUi\Domain\Model\Session\FullName;
use CompositeUi\Domain\Model\Session\LastName;
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
