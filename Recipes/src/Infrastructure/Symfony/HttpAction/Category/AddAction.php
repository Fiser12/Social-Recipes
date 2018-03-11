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

use LIN3S\SharedKernel\Domain\Model\Identity\Uuid;
use Recipes\Application\Command\Category\AddCategoryCommand;
use Recipes\Application\Query\Category\GetCategoriesByIds;
use Recipes\Application\Query\Category\GetCategoriesByIdsQuery;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddAction
{
    private $commandBus;
    private $categoriesByIds;

    public function __construct(
        CommandBus $commandBus,
        GetCategoriesByIds $categoriesByIds
    )
    {
        $this->commandBus = $commandBus;
        $this->categoriesByIds = $categoriesByIds;
    }

    public function __invoke(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = Uuid::generate();
        try {
            $command = new AddCategoryCommand(
                $data['recipeIds'],
                $data['translations'],
                $id
            );
        } catch(\InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }

        $this->commandBus->handle($command);

        $result = $this->categoriesByIds->__invoke(
            new GetCategoriesByIdsQuery([$id])
        );

        return new JsonResponse($result);
    }
}
