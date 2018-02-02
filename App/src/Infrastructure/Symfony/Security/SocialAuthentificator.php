<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use App\Application\Command\Session\FacebookLogInClientCommand;
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
use LIN3S\SharedKernel\Application\QueryBus;
use LIN3S\SharedKernel\Exception\InvalidArgumentException;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
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
    private $queryBus;
    private $facebookClientId;
    private $facebookAppSecret;

    public function __construct(
        ClientRegistry $clientRegistry,
        UrlGeneratorInterface $urlGenerator,
        MessageBusSupportingMiddleware $commandBus,
        QueryBus $queryBus,
        string $facebookClientId,
        string $facebookAppSecret
    )
    {
        $this->clientRegistry = $clientRegistry;
        $this->urlGenerator = $urlGenerator;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->facebookClientId = $facebookClientId;
        $this->facebookAppSecret = $facebookAppSecret;
    }

    public function getCredentials(Request $request) : ?FacebookLogInClientCommand
    {
        if ($request->getPathInfo() !== $this->urlGenerator->generate('oauth_facebook_check')) {
            return null;
        }
        $accessToken = $this->fetchAccessToken($this->client());

        $oauthUser = $this->client()->fetchUserFromToken($accessToken);
        $this->getFollowUsers($accessToken->getToken());
        $nameApi = $this->getFullName($accessToken->getToken());
        return new FacebookLogInClientCommand(
            $oauthUser->getId(),
            $accessToken->getToken(),
            $oauthUser->getEmail(),
            $nameApi['first_name'],
            $nameApi['last_name'],
            $this->getFollowUsers($accessToken->getToken())
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider) : UserInterface
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
        $this->commandBus->handle($credentials);

        return $userProvider->loadUserByUsername($credentials->email());
    }

    private function client() : OAuth2Client
    {
        return $this->clientRegistry->getClient('facebook');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) : RedirectResponse
    {
        if ($exception instanceof FinishRegistrationException) {
            $this->saveUserInfoToSession($request, $exception);
            $registrationUrl = $this->urlGenerator->generate('oauth_facebook_registration');

            return new RedirectResponse($registrationUrl);
        }
        $this->saveAuthenticationErrorToSession($request, $exception);
        $loginUrl = $this->urlGenerator->generate('app_home');

        return new RedirectResponse($loginUrl);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) : RedirectResponse
    {
        if (!$url = $this->getPreviousUrl($request, $providerKey)) {
            $url = $this->urlGenerator->generate('app_logged');
        }

        return new RedirectResponse($url);
    }

    public function start(Request $request, AuthenticationException $authException = null) : RedirectResponse
    {
        // not called in our app, but if it were, redirecting to the
        // login page makes sense
        $url = $this->urlGenerator->generate('app_logged');

        return new RedirectResponse($url);
    }

    private function getFullName(string $accessToken): array
    {
        $fb = new Facebook([
            'app_id' => $this->facebookClientId,
            'app_secret' => $this->facebookAppSecret,
            'default_graph_version' => 'v2.10',
            'default_access_token' => $accessToken,
        ]);
        try {
            $response = $fb->get('/me?fields=first_name,last_name')->getDecodedBody();
            return ['first_name' => $response['first_name'], 'last_name' => $response['last_name']];
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    private function getFollowUsersFromApi(string $accessToken): array
    {
        $fb = new Facebook([
            'app_id' => $this->facebookClientId,
            'app_secret' => $this->facebookAppSecret,
            'default_graph_version' => 'v2.10',
            'default_access_token' => $accessToken,
        ]);
        try {
            $response = $fb->get('/me/friends');
            return $response->getDecodedBody();
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    private function getFollowUsers(string $accessToken): array
    {
        $usersFollowers = [];
        $usersFollowersApi = $this->getFollowUsersFromApi($accessToken);

        if (isset($usersFollowersApi["data"])) {
            return [];
        }

        foreach ($usersFollowersApi["data"] as $followUser) {
            if (isset($followUser["id"])) {
                $usersFollowers[] = $followUser["id"];
            }
        }

        return $usersFollowers;
    }
}