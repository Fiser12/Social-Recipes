<?php

/*
 * This file is part of the Re_ Magazine project.
 *
 * Copyright (c) 2016-present-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Session\Infrastructure\Symfony\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Session\Application\Command\Session\FacebookLogInClientCommand;
use BenGorUser\User\Domain\Model\Exception\UserDoesNotExistException;
use BenGorUser\User\Domain\Model\Exception\UserEmailInvalidException;
use BenGorUser\User\Domain\Model\Exception\UserInactiveException;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator as BaseSocialAuthenticator;
use KnpU\OAuth2ClientBundle\Security\Exception\FinishRegistrationException;
use LIN3S\SharedKernel\Application\CommandBus;
use LIN3S\SharedKernel\Application\QueryBus;
use LIN3S\SharedKernel\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class SocialAuthenticator extends BaseSocialAuthenticator
{
    private $clientRegistry;
    private $urlGenerator;
    private $commandBus;
    private $facebookGraphApi;
    private $encoder;

    private $jwt;
    private $messageTimer;

    public function __construct(
        ClientRegistry $clientRegistry,
        UrlGeneratorInterface $urlGenerator,
        CommandBus $commandBus,
        QueryBus $queryBus,
        Facebook $facebookGraphApi,
        DefaultEncoder $encoder,
        SessionCookieGenerator $messageTimer
    )
    {
        $this->clientRegistry = $clientRegistry;
        $this->urlGenerator = $urlGenerator;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->facebookGraphApi = $facebookGraphApi;
        $this->encoder = $encoder;
        $this->messageTimer = $messageTimer;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() !== $this->urlGenerator->generate('oauth_facebook_check')) {
            return;
        }

        $accessToken = $this->fetchAccessToken($this->client());
        $oauthUser = $this->client()->fetchUserFromToken($accessToken);
        $email = $oauthUser->getEmail();
        $firstName = $oauthUser->getFirstName();
        $lastName = $oauthUser->getLastName();

        return new FacebookLogInClientCommand(
            $oauthUser->getId(),
            $accessToken->getToken(),
            $email,
            $firstName,
            $lastName,
            $this->getFollowUsers($accessToken->getToken())
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {

        if (!$credentials instanceof FacebookLogInClientCommand) {
            throw new InvalidArgumentException(
                sprintf(
                    'The given credentials must be an instance of %s, %s given.',
                    FacebookLogInClientCommand::class,
                    get_class($credentials)
                )
            );
        }

        try {
            $userValues = [
                'id' => $credentials->facebookId(),
                'email' => $credentials->email(),
                'first_name' => $credentials->firstName(),
                'last_name' => $credentials->lastName()
            ];
            $this->jwt = $this->encoder->encode($userValues);
            $this->commandBus->handle($credentials);
        } catch (UserEmailInvalidException | JWTEncodeFailureException $exception) {
            throw new FinishRegistrationException($userValues);
        }

        return $userProvider->loadUserByUsername($credentials->email());
    }

    private function client(): OAuth2Client
    {
        return $this->clientRegistry->getClient('facebook');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        if ($exception instanceof FinishRegistrationException) {
            $this->saveUserInfoToSession($request, $exception);
            $registrationUrl = $this->urlGenerator->generate('oauth_facebook_registration');
            return new RedirectResponse($registrationUrl);
        }
        $this->saveAuthenticationErrorToSession($request, $exception);
        $loginUrl = $this->urlGenerator->generate('app_homepage');

        return new RedirectResponse($loginUrl);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return $this->messageTimer->processRequest($this->jwt);
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        $url = $this->urlGenerator->generate('app_logged');

        return new RedirectResponse($url);
    }

    private function getFollowUsers(string $accessToken): array
    {
        $usersFollowersApi = $this->getFollowUsersFromApi($accessToken);

        $usersFollowers = [];

        if (!isset($usersFollowersApi["data"])) {
            return [];
        }

        foreach ($usersFollowersApi["data"] as $followUser) {
            if (isset($followUser["id"])) {
                $usersFollowers[] = $followUser["id"];
            }
        }

        return $usersFollowers;
    }

    private function getFollowUsersFromApi(string $accessToken): array
    {
        $this->facebookGraphApi->setDefaultAccessToken($accessToken);
        try {
            $response = $this->facebookGraphApi->get('/me/friends');
            return $response->getDecodedBody();
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

}
