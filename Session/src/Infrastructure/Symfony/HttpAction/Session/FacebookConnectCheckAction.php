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

namespace Session\Infrastructure\Symfony\HttpAction\Session;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class FacebookConnectCheckAction
{
    private $clientRegistry;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }

    public function __invoke(Request $request) : void
    {

    }
}
