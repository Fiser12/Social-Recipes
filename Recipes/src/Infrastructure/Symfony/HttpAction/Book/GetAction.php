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

use Recipes\Application\Command\Book\RemoveBookCommand;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAction
{
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        $this->commandBus->handle(new RemoveBookCommand("2"));
        return new JsonResponse('Hello recipes');
    }
}
