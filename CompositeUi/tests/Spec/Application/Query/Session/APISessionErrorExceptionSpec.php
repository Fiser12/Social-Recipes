<?php

namespace Spec\CompositeUi\Application\Query\Session;

use CompositeUi\Application\Query\Session\APISessionErrorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class APISessionErrorExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(APISessionErrorException::class);
    }
}
