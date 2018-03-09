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

namespace Recipes\Infrastructure\Symfony\HttpAction\Category;

use Recipes\Application\Query\Category\GetCategories;
use Recipes\Application\Query\Category\GetCategoriesByIds;
use Recipes\Application\Query\Category\GetCategoriesByIdsQuery;
use Recipes\Application\Query\Category\GetCategoriesQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAction
{
    private $categories;
    private $categoriesByIds;

    public function __construct(GetCategories $categories, GetCategoriesByIds $categoriesByIds)
    {

        $this->categories = $categories;
        $this->categoriesByIds = $categoriesByIds;
    }

    public function __invoke(Request $request)
    {
        if($ids = explode(',',$request->get('ids'))) {
            return new JsonResponse(
                $this->categoriesByIds->__invoke(
                    new GetCategoriesByIdsQuery($ids)
                )
            );
        }

        return new JsonResponse(
            $this->categories->__invoke(
                new GetCategoriesQuery(
                    (int) $request->get('page', 1),
                    (int) $request->get('pageSize', -1)
                )
            )
        );
    }
}
