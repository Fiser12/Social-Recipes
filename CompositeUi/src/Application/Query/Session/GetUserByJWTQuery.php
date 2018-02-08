<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CompositeUi\Application\Query\Session;

class GetUserByJWTQuery
{
    private $jwt;
    const URI = 'http://127.0.0.1:80/session/user/decode';
    const METHOD = 'GET';

    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }

    public function jwt(): string
    {
        return $this->jwt;
    }

    public function uri(): string
    {
        return self::URI;
    }

    public function method(): string
    {
        return self::METHOD;
    }
}