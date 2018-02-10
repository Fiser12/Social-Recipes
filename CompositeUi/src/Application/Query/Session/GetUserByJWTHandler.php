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
use GuzzleHttp\Exception\ClientException;

class GetUserByJWTHandler
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(GetUserByJWTQuery $query): array
    {
        try {
            $response = $this->client->request(
                GetUserByJWTQuery::METHOD,
                GetUserByJWTQuery::URI,
                [
                    'query' => ['jwt' => $query->jwt()]
                ]
            );
        } catch (ClientException $exception) {
            throw new APISessionErrorException(
                $exception->getMessage(),
                400
            );
        }

        if ($response->getStatusCode() !== 200) {
            throw new APISessionErrorException(
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}