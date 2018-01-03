<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Symfony\Framework;

use BenGorUser\DoctrineORMBridgeBundle\DoctrineORMBridgeBundle;
use BenGorUser\SimpleBusBridgeBundle\SimpleBusBridgeBundle;
use BenGorUser\SimpleBusBridgeBundle\SimpleBusDoctrineORMBridgeBundle;
use BenGorUser\SwiftMailerBridgeBundle\SwiftMailerBridgeBundle;
use BenGorUser\SymfonyRoutingBridgeBundle\SymfonyRoutingBridgeBundle;
use BenGorUser\SymfonySecurityBridgeBundle\SymfonySecurityBridgeBundle;
use BenGorUser\TwigBridgeBundle\TwigBridgeBundle;
use BenGorUser\UserBundle\BenGorUserBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use KnpU\OAuth2ClientBundle\KnpUOAuth2ClientBundle;
use LIN3S\Distribution\Php\Symfony\Lin3sDistributionBundle;
use LIN3S\SharedKernel\Infrastructure\Symfony\Bundle\Lin3sSharedKernelBundle;
use Sensio\Bundle\DistributionBundle\SensioDistributionBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;
use SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle;
use SimpleBus\SymfonyBridge\SimpleBusEventBusBundle;
use SmartCore\Bundle\AcceleratorCacheBundle\AcceleratorCacheBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Bundle\WebServerBundle\WebServerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new AcceleratorCacheBundle(),
            new DoctrineMigrationsBundle(),
            new DoctrineBundle(),
            new FrameworkBundle(),
            new Lin3sDistributionBundle(),
            new MonologBundle(),
            new SecurityBundle(),
            new SensioFrameworkExtraBundle(),
            new SwiftmailerBundle(),
            new TwigBundle(),
            new TwigBridgeBundle(),
            new SymfonyRoutingBridgeBundle(),
            new SymfonySecurityBridgeBundle(),
            new SwiftMailerBridgeBundle(),
            new DoctrineORMBridgeBundle(),
            new SimpleBusBridgeBundle(),
            new SimpleBusDoctrineORMBridgeBundle(),
            new BenGorUserBundle(),
            new KnpUOAuth2ClientBundle(),
            new Lin3sSharedKernelBundle(),
            new SimpleBusCommandBusBundle(),
            new SimpleBusEventBusBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new DebugBundle();
            $bundles[] = new WebProfilerBundle();
            $bundles[] = new SensioDistributionBundle();
            $bundles[] = new SensioGeneratorBundle();
            $bundles[] = new WebServerBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/../../../../var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/../../../../var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
