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

use Recipes\Application\Query\Recipes\GetRecipesByBooks;
use Recipes\Application\Query\Recipes\GetRecipesByBooksQuery;
use Recipes\Application\Query\Recipes\GetRecipesByCategories;
use Recipes\Application\Query\Recipes\GetRecipesByCategoriesQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetBooksAction
{
    private $recipesByBooks;

    public function __construct(GetRecipesByBooks $recipesByBooks)
    {
        $this->recipesByBooks = $recipesByBooks;
    }

    public function __invoke(Request $request)
    {
        if ($ids = explode(',', $request->get('booksIds'))) {
            $this->recipesByBooks->__invoke(
                new GetRecipesByBooksQuery(
                    $ids,
                    (int) $request->get('page', 1),
                    (int) $request->get('pageSize', -1)
                )
            );
        }

        return new JsonResponse('Failed parameters, send this parameters: booksIds<array>', 400);
    }
}
