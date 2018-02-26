<?php

namespace Recipes\Domain\Model\Book;

class Scope
{
    private $scope;

    //TODO Crear un enum
    public function __construct(string $scope)
    {
        $this->scope = $scope;
    }

    public function scope() : string
    {
        return $this->scope;
    }
}