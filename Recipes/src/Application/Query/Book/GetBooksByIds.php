<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetBooksByIds
{
    private $view;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(BookView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetBooksByIdsQuery $query): array
    {
        return array_merge(
            $this->friendsRecipes($query),
            $this->ownerRecipes($query)
        );
    }

    private function friendsRecipes(GetBooksByIdsQuery $query): array
    {
        $friends = $this->userRepository->userOfId(UserId::generate($query->userId()))->friends();
        return $this->view->list(
            [
                'ids' => $query->ids(),
                'scopes' => $query->userId() !== null
                    ? [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ]
                    : [Scope::PUBLIC],
                'owners' => $friends
            ]
        );
    }

    private function ownerRecipes(GetBooksByIdsQuery $query): array
    {
        return $this->view->list(
            [
                'ids' => $query->ids(),
                'owners' => [$query->userId()]
            ]
        );
    }
}