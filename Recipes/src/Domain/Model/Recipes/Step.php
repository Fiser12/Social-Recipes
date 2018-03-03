<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Translation\Translatable;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Step
{
    private $id;
    private $ingredients;
    private $tools;
    private $recipe;

    //TODO Agregar imagen
    use Translatable{
        Translatable::__construct as private __translatableConstruct;
    }

    public function __construct(
        StepId $id,
        IngredientsCollection $ingredients,
        ToolsCollection $tools,
        Recipe $recipe
    )
    {
        $this->__translatableConstruct();
        $this->id = $id;
        $this->ingredients = $ingredients;
        $this->tools = $tools;
        $this->recipe = $recipe;
    }

    public function id(): StepId
    {
        return $this->id;
    }

    public function ingredients(): IngredientsCollection
    {
        return $this->ingredients;
    }

    public function tools(): ToolsCollection
    {
        return $this->tools;
    }

    public function recipe(): Recipe
    {
        return $this->recipe;
    }

    protected function translationClass(): string
    {
        return StepTranslation::class;
    }
}