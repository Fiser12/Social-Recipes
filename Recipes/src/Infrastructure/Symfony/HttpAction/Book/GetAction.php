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

namespace Recipes\Infrastructure\Symfony\HttpAction\Book;

use Recipes\Application\Query\Book\GetBooksByFollow;
use Recipes\Application\Query\Book\GetBooksByFollowQuery;
use Recipes\Application\Query\Book\GetBooksByIds;
use Recipes\Application\Query\Book\GetBooksByIdsQuery;
use Recipes\Application\Query\Book\GetBooksByOwner;
use Recipes\Application\Query\Book\GetBooksByOwnerQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAction
{
    private $booksByIds;
    private $booksByFollow;
    private $booksByOwner;

    public function __construct(
        GetBooksByIds $booksByIds,
        GetBooksByFollow $booksByFollow,
        GetBooksByOwner $booksByOwner
    )
    {

        $this->booksByIds = $booksByIds;
        $this->booksByOwner = $booksByOwner;
        $this->booksByFollow = $booksByFollow;
    }

    public function __invoke(Request $request)
    {
        if(!empty($request->get('ids'))) {
            $ids = explode(',',$request->get('ids'));
            $ownerId = $request->get('ownerId');

            return new JsonResponse(
                $this->booksByIds->__invoke(
                    new GetBooksByIdsQuery(
                        $ids,
                        empty($ownerId) ? null : $ownerId
                    )
                )
            );
        }

        if(!empty($request->get('ownerId'))) {
            $ownerId = $request->get('ownerId');
            return new JsonResponse(
                $this->booksByOwner->__invoke(
                    new GetBooksByOwnerQuery(
                        $ownerId,
                        (int) $request->get('page', 1),
                        (int) $request->get('pageSize', -1)
                    )
                )
            );
        }

        if(!empty($request->get('userId'))) {
            $userId = $request->get('userId');
            return new JsonResponse(
                $this->booksByFollow->__invoke(
                    new GetBooksByFollowQuery(
                        $userId,
                        (int) $request->get('page', 1),
                        (int) $request->get('pageSize', -1)
                    )
                )
            );
        }

        return new JsonResponse(
            'Failed parameters, send this parameters:
             GetBooksByIds: ids<array>, ownerId<?string>
             GetBooksByFollow: userId<string>, page<?int>, pageSize<?int>
             GetBooksByOwner: ownerId<string>, page<?int>, pageSize<?int>', 400);
    }
}