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

namespace Gateway\Infrastructure\Symfony\HttpAction;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeAction extends Controller
{
    private $twig;
    private $urlGenerator;

    public function __construct(
        \Twig_Environment $twig,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(Request $request) : Response
    {
        if($user = $this->getUser()){
            $loginUrl = $this->urlGenerator->generate('app_timeline', ['_locale' => $request->getLocale()]);
            return new RedirectResponse($loginUrl);
        }

        $response = new Response(
            $this->twig->render('pages/home.html.twig')
        );
        return $response;
    }
}
