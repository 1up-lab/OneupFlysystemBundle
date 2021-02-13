<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilesystemPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('oneup_flysystem.mount_manager')) {
            return;
        }

        $mountManager = $container->getDefinition('oneup_flysystem.mount_manager');
        $configuredFilesystems = $container->findTaggedServiceIds('oneup_flysystem.filesystem');
        $filesystems = [];

        foreach ($configuredFilesystems as $id => $attributes) {
            $filesystems[$id] = new Reference($id);
        }

        $mountManager->replaceArgument(0, $filesystems);
    }
}
