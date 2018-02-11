<?php

declare(strict_types=1);

namespace CompositeUi\Infrastructure\Symfony\Security\Session;

use CompositeUi\Application\Query\Session\APISessionErrorException;
use CompositeUi\Application\Query\Session\GetUserByJWTHandler;
use CompositeUi\Application\Query\Session\GetUserByJWTQuery;
use CompositeUi\Domain\Model\Session\FirstName;
use CompositeUi\Domain\Model\Session\FullName;
use CompositeUi\Domain\Model\Session\LastName;
use CompositeUi\Domain\Model\Session\User;
use CompositeUi\Domain\Model\Session\UserEmail;
use CompositeUi\Domain\Model\Session\UserFacebookId;
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