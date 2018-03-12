<?php

namespace Recipes\Application\Command\Category;

class EditCategoryCommand
{
    private $recipeIds;
    private $translations;
    private $id;

    public function __construct(
        array $recipeIds,
        array $translations,
        string $id
    )
    {
        $this->recipeIds = $recipeIds;
        $this->translations = $translations;
        $this->id = $id;
    }

    public function recipeIds(): array
    {
        return $this->recipeIds;
    }

    public function translations(): array
    {
        return $this->translations;
    }

    public function id(): string
    {
        return $this->id;
    }

}