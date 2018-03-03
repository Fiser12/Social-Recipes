<?php

namespace Recipes\Domain\Model;

use Recipes\Domain\Model\Translation\ScopeIsInvalid;

class Scope
{
    const PRIVATE = 'private';
    const PROTECTED = 'protected';
    const PUBLIC = 'public';

    private $scope;

    public function __construct(string $scope)
    {
        $this->setScope($scope);
    }

    private function setScope(string $scope) : void
    {
        $this->checkScopeIsValid($scope);
        $this->scope = $scope;
    }

    private function checkScopeIsValid(string $scope) : void
    {
        if (!in_array($scope, $this->scopes(), true)) {
            throw new ScopeIsInvalid();
        }
    }

    public static function scopes() : array
    {
        return [
            self::PRIVATE,
            self::PROTECTED,
            self::PUBLIC,
        ];
    }

    public function scope() : string
    {
        return $this->scope;
    }

    public function equals(Scope $scope) : bool
    {
        return $this->scope() === $scope->scope();
    }

    public function __toString() : string
    {
        return (string) $this->scope();
    }
}