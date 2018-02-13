<?php

namespace Spec\Recipes\Application\Query\Session;

use Recipes\Application\Query\Session\GetUserByJWTQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetUserByJWTQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('jwt');
    }

    function it_is_type()
    {
        $this->shouldHaveType(GetUserByJWTQuery::class);
    }

    function it_is_initializable()
    {
        $this->jwt()->shouldBe('jwt');
    }

}
