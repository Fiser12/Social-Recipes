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

namespace Recipes\Infrastructure\Persistence\Sql;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
interface SqlHydrator
{
    public function build(array $row);
}
