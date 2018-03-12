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

use Recipes\Application\Command\Recipes\EditRecipeCommand;
use Recipes\Application\Query\Recipes\GetRecipesByIds;
use Recipes\Application\Query\Recipes\GetRecipesByIdsQuery;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateAction extends Controller
{
    private $commandBus;
    private $recipesByIds;

    public function __construct(CommandBus $commandBus, GetRecipesByIds $recipesByIds)
    {
        $this->commandBus = $commandBus;
        $this->recipesByIds = $recipesByIds;
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->facebookId()->id();
        $data = json_decode($request->getContent(), true);
        $id = $request->get('id');

        try {
            $command = new EditRecipeCommand(
                $data['steps'],
                $data['hashtag'],
                $data['ingredients'],
                $data['tools'],
                $data['categories'],
                (int)$data['servings'],
                (int)$data['timeSeconds'],
                $data['difficulty'],
                $data['scope'],
                $userId,
                $data['books'],
                $data['translations'],
                $id
            );
        } catch(\InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }

        $this->commandBus->handle($command);

        $result = $this->recipesByIds->__invoke(
            new GetRecipesByIdsQuery([$id], $userId)
        );

        return new JsonResponse($result);
    }
}
