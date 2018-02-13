<?php

declare(strict_types=1);

namespace Recipes\Infrastructure\Symfony\Security\Session;

use Recipes\Application\Query\Session\APISessionErrorException;
use Recipes\Application\Query\Session\GetUserByJWTHandler;
use Recipes\Application\Query\Session\GetUserByJWTQuery;
use Recipes\Domain\Model\Session\FirstName;
use Recipes\Domain\Model\Session\FullName;
use Recipes\Domain\Model\Session\LastName;
use Recipes\Domain\Model\Session\User;
use Recipes\Domain\Model\Session\UserEmail;
use Recipes\Domain\Model\Session\UserFacebookId;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTUserProvider implements UserProviderInterface
{
    private $getJwtHandler;

    public function __construct(GetUserByJWTHandler $getJwtHandler)
    {
        $this->getJwtHandler = $getJwtHandler;
    }

    public function loadUserByUsername($jwt): ?User
    {
        try {
            $response = $this->getJwtHandler->__invoke(new GetUserByJWTQuery($jwt));
        } catch (APISessionErrorException $exception) {
            return null;
        }

        $user = new User(
            new UserFacebookId($response['user']['id']),
            new UserEmail($response['user']['email']),
            new FullName(
                new FirstName($response['user']['first_name']),
                new LastName($response['user']['last_name'])
            ),
            $jwt
        );

        return $user;
    }

    public function refreshUser(UserInterface $user): ?User
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->jwt());
    }

    public function supportsClass($class): string
    {
        return User::class;
    }
}