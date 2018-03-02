<?php

namespace Recipes\Domain\Model\Recipes;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Hashtag
{
    private $hashtag;

    public function __construct(string $hashtag)
    {

        $this->hashtag = $hashtag;
    }

    public function hashtag(): string
    {
        return $this->hashtag;
    }
}