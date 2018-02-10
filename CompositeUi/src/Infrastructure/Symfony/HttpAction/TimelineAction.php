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
use CompositeUi\Domain\Model\Session\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TimelineAction extends Controller
{
    private $twig;
    private $router;
    private $tokenStorage;

    public function __construct(
        \Twig_Environment $twig,
        RouterInterface $router,
        TokenStorage $tokenStorage
    )
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(Request $request): Response
    {
        $user = $this->getUser();
        /**@var User $user */
        return new Response(
            $this->twig->render(
                'pages/timeline.html.twig',
                ['user' => $user->fullName()->firstName()->firstName() . ' ' . $user->fullName()->lastName()->lastName()]
            )
        );
    }
}
