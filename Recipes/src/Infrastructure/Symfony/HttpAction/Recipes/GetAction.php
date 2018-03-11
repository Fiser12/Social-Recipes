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

use Recipes\Application\Query\Recipes\GetRecipesByIds;
use Recipes\Application\Query\Recipes\GetRecipesByIdsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAction extends Controller
{
    private $recipesByIds;

    public function __construct(GetRecipesByIds $recipesByIds)
    {
        $this->recipesByIds = $recipesByIds;
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->facebookId()->id();

        if(null !== $request->get('ids')) {
            $ids = explode(',',$request->get('ids'));
            return new JsonResponse(
                $this->recipesByIds->__invoke(
                    new GetRecipesByIdsQuery(
                        $ids,
                        $userId
                    )
                )
            );
        }
        return new JsonResponse(
            'Failed parameters, send this parameters:
             GetRecipesByIds: ids<array>, ownerId<?string>, 400');
    }
}
