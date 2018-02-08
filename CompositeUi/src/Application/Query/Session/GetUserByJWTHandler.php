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

use GuzzleHttp\Client;

class GetUserByJWTHandler
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(GetUserByJWTQuery $query): array
    {
        $response = $this->client->request(
            GetUserByJWTQuery::METHOD,
            GetUserByJWTQuery::URI,
            [
                'query' => ['jwt' => $query->jwt()]
            ]
        );
        return $response;
    }
}