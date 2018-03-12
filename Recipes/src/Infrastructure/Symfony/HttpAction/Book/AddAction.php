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

use LIN3S\SharedKernel\Domain\Model\Identity\Uuid;
use Recipes\Application\Command\Book\AddBookCommand;
use Recipes\Application\Query\Book\GetBooksByIds;
use Recipes\Application\Query\Book\GetBooksByIdsQuery;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddAction extends Controller
{
    private $commandBus;
    private $booksByIds;

    public function __construct(CommandBus $commandBus, GetBooksByIds $booksByIds)
    {
        $this->commandBus = $commandBus;
        $this->booksByIds = $booksByIds;
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->facebookId()->id();
        $data = json_decode($request->getContent(), true);
        $id = Uuid::generate();

        try {
            $command = new AddBookCommand(
                $userId,
                $data['scope'],
                $data['follows'],
                $data['recipeIds'],
                $data['translations'],
                $id
            );
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }

        $this->commandBus->handle($command);

        $result = $this->booksByIds->__invoke(
            new GetBooksByIdsQuery([$id], $userId)
        );

        return new JsonResponse($result);
    }
}
