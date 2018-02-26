<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Translation\Translatable;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Step extends Translatable
{
    private $id;
    private $ingredients;
    private $tools;
    //TODO Agregar imagen

    public function __construct(StepId $id, IngredientsCollection $ingredients, ToolsCollection $tools)
    {
        parent::__construct();
        $this->id = $id;
        $this->ingredients = $ingredients;
        $this->tools = $tools;
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

    protected function translationClass(): string
    {
        return StepTranslation::class;
    }
}