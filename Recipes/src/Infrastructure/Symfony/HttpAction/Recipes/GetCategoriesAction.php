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

use Recipes\Application\Query\Recipes\GetRecipesByCategories;
use Recipes\Application\Query\Recipes\GetRecipesByCategoriesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetCategoriesAction extends Controller
{
    private $recipesByCategories;

    public function __construct(GetRecipesByCategories $recipesByCategories)
    {
        $this->recipesByCategories = $recipesByCategories;
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->facebookId()->id();

        if(null !== $request->get('categoryIds')) {
            $ids = explode(',',$request->get('categoryIds'));
            $this->recipesByCategories->__invoke(
                new GetRecipesByCategoriesQuery(
                    $userId,
                    $ids,
                    (int) $request->get('page', 1),
                    (int) $request->get('pageSize', -1)
                )
            );
        }

        return new JsonResponse('Failed parameters, send this parameters: categoryIds<array>', 400);
    }
}
