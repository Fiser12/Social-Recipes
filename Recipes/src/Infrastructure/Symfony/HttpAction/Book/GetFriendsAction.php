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
use Recipes\Application\Query\Book\GetBooksByFriends;
use Recipes\Application\Query\Book\GetBooksByFriendsQuery;
use Recipes\Application\Query\Book\GetBooksByIds;
use Recipes\Application\Query\Book\GetBooksByIdsQuery;
use Recipes\Application\Query\Book\GetBooksByOwner;
use Recipes\Application\Query\Book\GetBooksByOwnerQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetFriendsAction
{
    private $booksByFriends;

    public function __construct(GetBooksByFriends $booksByFriends)
    {

        $this->booksByFriends = $booksByFriends;
    }

    public function __invoke(Request $request)
    {
        if($ownerId = $request->get('ownerId')) {
            return new JsonResponse(
                $this->booksByFriends->__invoke(
                    new GetBooksByFriendsQuery(
                        (string) $ownerId,
                        (int) $request->get('page', 1),
                        (int) $request->get('pageSize', -1)
                    )
                )
            );
        }

        return new JsonResponse(
            'Failed parameters, send this parameters:
             GetBooksByFriends: ownerId<string>, page<?int>, pageSize<?int>', 400);
    }
}
