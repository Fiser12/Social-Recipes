<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Symfony\HttpAction;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class FacebookConnectCheckAction
{
    public function __invoke(Request $request) : void
    {
    }
}
