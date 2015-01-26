<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilesystemPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('oneup_flysystem.mount_manager')) {
            return;
        }

        $mountManager = $container->getDefinition('oneup_flysystem.mount_manager');
        $filesystems = $container->findTaggedServiceIds('oneup_flysystem.filesystem');

        foreach ($filesystems as $id => $attributes) {
            foreach ($attributes as $attribute) {
                // a filesystem which should be managed by this bundle
                // must provide a name with its tag
                if (!isset($attribute['mount'])) {
                    continue;
                }

                $prefix = $attribute['mount'];

                // add filesystem to the map
                $mountManager->addMethodCall('mountFilesystem', array($prefix, new Reference($id)));
            }
        }
    }
}
