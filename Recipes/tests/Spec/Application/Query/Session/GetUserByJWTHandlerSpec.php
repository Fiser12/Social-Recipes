<?php

namespace Spec\Recipes\Application\Query\Session;

use Recipes\Application\Query\Session\APISessionErrorException;
use Recipes\Application\Query\Session\GetUserByJWTHandler;
use Recipes\Application\Query\Session\GetUserByJWTQuery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetUserByJWTHandlerSpec extends ObjectBehavior
{
    function let(Client $client, ContainerInterface $container)
    {
        $this->beConstructedWith($client, $container);
    }

    function it_is_type()
    {
        $this->shouldHaveType(GetUserByJWTHandler::class);
    }

    function it_is_invoke(
        Client $client,
        GetUserByJWTQuery $query,
        Response $response,
        Stream $stream,
        ContainerInterface $container
    )
    {
        $query->jwt()->willReturn('jwt');
        $container->getParameter(Argument::type('string'))->willReturn('secret');

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
