<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class Book extends Translatable implements AggregateRoot
{
    //TODO Agregar imagen
    private $id;
    private $owner;
    private $follow;
    private $scope;

    use AggregateRootCapabilities;

    public function __construct(BookId $id, UserId $owner, Scope $scope, UsersCollection $follow)
    {
        parent::__construct();
        $this->id = $id;
        $this->owner = $owner;
        $this->follow = $follow;
        $this->scope = $scope;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function owner(): UserId
    {
        return $this->owner;
    }

    public function follow(): UsersCollection
    {
        return $this->follow;
    }

    public function scope(): Scope
    {
        return $this->scope;
    }

    protected function translationClass(): string
    {
        return BookTranslation::class;
    }
}