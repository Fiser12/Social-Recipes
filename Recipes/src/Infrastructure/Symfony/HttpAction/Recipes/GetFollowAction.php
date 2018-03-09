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

use Recipes\Application\Query\Recipes\GetRecipesByFollow;
use Recipes\Application\Query\Recipes\GetRecipesByFollowQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetFollowAction
{
    private $recipesByFollow;

    public function __construct(GetRecipesByFollow $recipesByFollow)
    {
        $this->recipesByFollow = $recipesByFollow;
    }

    public function __invoke(Request $request)
    {
        if ($followId = $request->get('userId')) {
            $this->recipesByFollow->__invoke(
                new GetRecipesByFollowQuery(
                    (string)$followId,
                    (int)$request->get('page', 1),
                    (int)$request->get('pageSize', -1)
                )
            );
        }

        return new JsonResponse('Failed parameters, send this parameters: userId<array>', 400);
    }
}
