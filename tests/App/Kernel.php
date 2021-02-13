<?php

declare(strict_types=1);

use Oneup\FlysystemBundle\OneupFlysystemBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),

            // Test this Bundle
            new OneupFlysystemBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/config.yml');
    }

    public function getProjectDir()
    {
        return __DIR__;
    }
}
