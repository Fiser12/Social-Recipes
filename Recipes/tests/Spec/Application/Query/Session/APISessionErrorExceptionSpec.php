<?php

namespace Spec\Recipes\Application\Query\Session;

use Recipes\Application\Query\Session\APISessionErrorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class APISessionErrorExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(APISessionErrorException::class);
    }
}
