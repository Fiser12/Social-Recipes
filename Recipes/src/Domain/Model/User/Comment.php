<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Exception\DomainException;
use Recipes\Domain\Model\Recipes\RecipeId;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Comment
{
    private $comment;
    private $owner;
    private $recipe;

    public function __construct(string $comment, UserId $owner, RecipeId $recipe)
    {
        $this->setComment($comment);
        $this->owner = $owner;
        $this->recipe = $recipe;
    }

    private function setComment(string $comment): void
    {
        if (empty($comment)) {
            throw new DomainException('Comment: Cannot be empty');
        }
        $this->comment = $comment;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function owner(): UserId
    {
        return $this->owner;
    }

    public function recipeId(): RecipeId
    {
        return $this->recipe;
    }
}