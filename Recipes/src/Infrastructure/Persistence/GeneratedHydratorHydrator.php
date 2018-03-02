<?php

/*
 * This file is part of the Euskaltel-R project.
 *
 * Copyright (c) 2017-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Recipes\Infrastructure\Persistence;

use GeneratedHydrator\Configuration;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class GeneratedHydratorHydrator implements Hydrator
{
    private $hydrator;
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
        $this->hydrator = $this->setHydrator();
    }

    public function hydrate(array $data)
    {
        return $this->hydrator->hydrate($data, $this->getReflectedClass());
    }

    private function setHydrator()
    {
        $config = new Configuration($this->className);
        $hydratorClass = $config->createFactory()->getHydratorClass();

        return new $hydratorClass();
    }

    private function getReflectedClass()
    {
        $reflectionClass = new \ReflectionClass($this->className);

        return $reflectionClass->newInstanceWithoutConstructor();
    }
}