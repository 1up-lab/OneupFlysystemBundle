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
        $filesystems = [];
        $configuredFilesystems = $container->findTaggedServiceIds('oneup_flysystem.filesystem');
        foreach ($configuredFilesystems as $id => $attributes) {
            $filesystems[$id] = new Reference($id);
            $filesystem = $container->getDefinition($id);
            $config = $filesystem->getArgument(0);
            $adapter = sprintf(
                'oneup_flysystem.%s_adapter',
                $config['adapter']
            );

            if ($config['cache']) {
                $cache = sprintf(
                    'oneup_flysystem.%s_cache',
                    $config['cache']
                );
                $adapterDef = $container->getDefinition($adapter . '_cached')
                    ->replaceArgument(0, new Reference($adapter))
                    ->replaceArgument(1, new Reference($cache));
            } else {
                $adapterDef = new Reference($adapter);
            }
            $filesystem->replaceArgument(0, $adapterDef);

            if (!$container->hasDefinition('oneup_flysystem.mount_manager')) {
                return;
            }

            $mountManager = $container->getDefinition('oneup_flysystem.mount_manager');
            $mountManager->replaceArgument(0, $filesystems);
        }
    }
}
