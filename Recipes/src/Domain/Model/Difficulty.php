<?php

namespace Recipes\Domain\Model;

use Recipes\Domain\Model\Translation\DifficultyIsInvalid;

class Difficulty
{
    const EASY = 'easy';
    const MEDIUM = 'medium';
    const HARD = 'hard';

    private $difficulty;

    public function __construct(string $difficulty)
    {
        $this->setDifficulty($difficulty);
    }

    private function setDifficulty(string $difficulty) : void
    {
        $this->checkDifficultyIsValid($difficulty);
        $this->difficulty = $difficulty;
    }

    private function checkDifficultyIsValid(string $difficulty) : void
    {
        if (!in_array($difficulty, $this->difficulties(), true)) {
            throw new DifficultyIsInvalid($difficulty);
        }
    }

    public static function difficulties() : array
    {
        return [
            self::EASY,
            self::MEDIUM,
            self::HARD,
        ];
    }

    public function difficulty() : string
    {
        return $this->difficulty;
    }

    public function equals(Difficulty $difficulty) : bool
    {
        return $this->difficulty() === $difficulty->difficulty();
    }

    public function __toString() : string
    {
        return (string) $this->difficulty();
    }
}