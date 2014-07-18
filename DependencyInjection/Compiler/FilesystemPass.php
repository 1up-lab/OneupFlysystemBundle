<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class FilesystemPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('oneup_flysystem.filesystem_map')) {
            return;
        }

        $map = $container->getDefinition('oneup_flysystem.filesystem_map');
        $filesystems = $container->findTaggedServiceIds('oneup_flysystem.filesystem');

        foreach ($filesystems as $id => $attributes) {
            // a filesystem which should be managed by this bundle
            // must provide a name with its tag
            if (!isset($attributes['name'])) {
                continue;
            }

            $name = $attributes['name'];

            // add filesystem to the map
            $map->addMethodCall('add', array($name, new Reference($id)));
        }
    }
}