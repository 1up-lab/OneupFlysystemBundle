<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle;

use Oneup\FlysystemBundle\DependencyInjection\Compiler\FilesystemPass;
use Oneup\FlysystemBundle\StreamWrapper\StreamWrapperManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OneupFlysystemBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new FilesystemPass());
    }

    public function boot(): void
    {
        parent::boot();

        $manager = $this->container->get('oneup_flysystem.stream_wrapper.manager', ContainerInterface::NULL_ON_INVALID_REFERENCE);

        if ($manager instanceof StreamWrapperManager) {
            $manager->register();
        }
    }

    public function shutdown(): void
    {
        parent::shutdown();

        $manager = $this->container->get('oneup_flysystem.stream_wrapper.manager', ContainerInterface::NULL_ON_INVALID_REFERENCE);

        if ($manager instanceof StreamWrapperManager) {
            $manager->unregister();
        }
    }
}
