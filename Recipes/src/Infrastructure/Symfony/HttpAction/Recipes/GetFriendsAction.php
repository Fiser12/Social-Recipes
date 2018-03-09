<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Recipes\Infrastructure\Symfony\HttpAction\Recipes;

use Recipes\Application\Query\Recipes\GetRecipesByFriends;
use Recipes\Application\Query\Recipes\GetRecipesByFriendsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetFriendsAction
{
    private $recipesByFriends;

    public function __construct(GetRecipesByFriends $recipesByFriends)
    {
        $this->recipesByFriends = $recipesByFriends;
    }

    public function __invoke(Request $request)
    {
        if ($userId = $request->get('userId')) {
            $this->recipesByFriends->__invoke(
                new GetRecipesByFriendsQuery(
                    (string)$userId,
                    (int)$request->get('page', 1),
                    (int)$request->get('pageSize', -1)
                )
            );
        }

        return new JsonResponse('Failed parameters, send this parameters: userId<array>', 400);
    }
}
