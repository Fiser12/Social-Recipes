<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CompositeUi\Infrastructure\Symfony\HttpAction;

use CompositeUi\Application\Query\Session\APISessionErrorException;
use CompositeUi\Application\Query\Session\GetUserByJWTHandler;
use CompositeUi\Application\Query\Session\GetUserByJWTQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class TimelineAction
{
    private $twig;
    private $getJwtHandler;
    private $router;

    public function __construct(
        \Twig_Environment $twig,
        GetUserByJWTHandler $getJwtHandler,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->getJwtHandler = $getJwtHandler;
        $this->router = $router;
    }

    public function __invoke(Request $request): Response
    {
        if (!$jwt = $request->cookies->get('Authorization')) {
            $this->router->generate('app_home');
            return new RedirectResponse($this->router->generate('app_home', ['removeCookie' => 1]));
        }

        try {
            $response = $this->getJwtHandler->__invoke(new GetUserByJWTQuery($jwt));
            return new Response(
                $this->twig->render(
                    'pages/timeline.html.twig',
                    ['user' => $response['user']['first_name'] . ' ' . $response['user']['last_name']]
                )
            );
        } catch (APISessionErrorException $exception) {
            return new RedirectResponse($this->router->generate('app_home', ['removeCookie' => 1]));
        }
    }
}
