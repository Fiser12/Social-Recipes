<?php

namespace Spec\CompositeUi\Application\Query\Session;

use CompositeUi\Application\Query\Session\APISessionErrorException;
use CompositeUi\Application\Query\Session\GetUserByJWTHandler;
use CompositeUi\Application\Query\Session\GetUserByJWTQuery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetUserByJWTHandlerSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_type()
    {
        $this->shouldHaveType(GetUserByJWTHandler::class);
    }

    function it_is_invoke(
        Client $client,
        GetUserByJWTQuery $query,
        Response $response,
        Stream $stream
    )
    {
        $query->jwt()->willReturn('jwt');
        $client->request(
            Argument::type('string'),
            Argument::type('string'),
            Argument::type('array')
        )->willReturn($response);

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('{"user": "user"}');
        $this->__invoke($query)->shouldReturn(['user' => 'user']);
    }
}
