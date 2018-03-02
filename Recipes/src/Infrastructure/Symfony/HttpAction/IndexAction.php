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

namespace Recipes\Infrastructure\Symfony\HttpAction;

use Recipes\Infrastructure\Persistence\Sql\Domain\Model\Recipes\SqlRecipeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexAction
{
    private $container;
    private $categoryRepository;

    public function __construct(
        ContainerInterface $container,
        SqlRecipeRepository $categoryRepository
    )
    {
        $this->container = $container;
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(Request $request)
    {

        return new JsonResponse('Hello recipes');
    }
}
