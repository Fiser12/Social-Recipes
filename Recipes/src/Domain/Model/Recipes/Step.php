<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Translation\Translatable;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Step
{
    protected $id;
    protected $ingredients;
    protected $tools;
    protected $recipe;

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
        return new IngredientsCollection($this->ingredients->getValues());
    }

    public function tools(): ToolsCollection
    {
        return new ToolsCollection($this->tools->getValues());
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