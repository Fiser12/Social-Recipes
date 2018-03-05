<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Video
{
    protected $url;

    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    private function setUrl(string $url): void
    {
        if (empty($url)) {
            throw new DomainException('URL: Cannot be empty');
        }
        $this->url = $url;
    }

    public function url(): string
    {
        return $this->url;
    }
}