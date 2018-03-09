<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Session\Infrastructure\Symfony\HttpAction\Session;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Session\Application\Query\Session\GetUserByIdHandler;
use Session\Application\Query\Session\GetUserByIdQuery;
use Session\Application\Query\Session\JWTDecodeHandler;
use Session\Application\Query\Session\JWTDecodeQuery;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUserByIdAction
{
    private $handler;
    private $container;

    public function __construct(GetUserByIdHandler $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->container = $container;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->container->getParameter('secret') !== $request->headers->get('token-api')) {
            return new JsonResponse('Secret doesnt exist', 401);
        }

        if (!$id = $request->get('id')) {
            return new JsonResponse('Id query not exist', 401);
        }

        $user = $this->handler->__invoke(
            new GetUserByIdQuery($request->get('id'))
        );

        $result = [
            'user' => $user
        ];
        $code = 200;

        return new JsonResponse($result, $code);
    }
}
