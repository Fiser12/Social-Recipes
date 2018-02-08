<?php

namespace Session\Infrastructure\Symfony\Security;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class SessionCookieGenerator
{
    private $router;

    public function __construct(
        RouterInterface $router
    )
    {
        $this->router = $router;
    }

    public function processRequest(Request $request, string $jwt)
    {
        $session = $request->cookies->get('Authorization');

        if ($session) {
            return new RedirectResponse($this->router->generate('app_logged'));
        } else {
            $cookie = new Cookie('Authorization', $jwt);
            $response = new RedirectResponse($this->router->generate('app_logged'));
            $response->headers->setCookie($cookie);
            return $response;
        }
    }
}
