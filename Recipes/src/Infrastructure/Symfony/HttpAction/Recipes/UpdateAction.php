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
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateAction
{
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        try {
            $command = new EditRecipeCommand(
                ...array_merge(json_decode($request->getContent(), true), $request->get('id'))
            );
        } catch(\InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }

        $this->commandBus->handle($command);

        return new JsonResponse('Recipe edited');
    }
}
