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

use Recipes\Application\Command\Book\EditBookCommand;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UpdateAction extends Controller
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->facebookId()->id();

        try {
            $command = new EditBookCommand(
                ...array_merge(['userId' => $userId], json_decode($request->getContent(), true), ['id' =>$request->get('id')])
            );
        } catch(\InvalidArgumentException $exception) {
            return new JsonResponse($exception->getMessage(), 400);
        }

        $this->commandBus->handle($command);

        return new JsonResponse('Book edited');
    }
}
