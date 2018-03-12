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

namespace Session\Application\Query\Session;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder;

/**
 * @author Ruben Garcia <ruben@lin3s.com>
 */
class JWTDecode
{
    private $encoder;

    public function __construct(DefaultEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function __invoke(JWTDecodeQuery $command): array
    {
        return $this->encoder->decode($command->jwt());
    }
}

