<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PluginPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $byName = array();
        $plugins = $container->findTaggedServiceIds('oneup_flysystem.plugin');
        $filesystems = $container->findTaggedServiceIds('oneup_flysystem.filesystem');

        foreach ($filesystems as $id => $attributes) {
            if (!isset($attributes[0]['key'])) {
                continue;
            }

            $byName[$attributes[0]['key']] = $id;
        }

        foreach ($plugins as $pluginId => $attributes) {
            // there can be multiple plugin tags,
            // so iterate over attributes
            foreach ($attributes as $attribute) {
                // check if filesystem key is set.
                // if so, attach this plugin to this filesystem
                if (isset($attribute['filesystem'])) {
                    $name = $attribute['filesystem'];

                    if (!isset($byName[$name])) {
                        throw new \InvalidArgumentException(sprintf('The filesystem "%s" is not configured.', $name));
                    }

                    $filesystem = $container->getDefinition($byName[$name]);
                    $filesystem->addMethodCall('addPlugin', array(new Reference($pluginId)));

                    continue;
                }

                // otherwise attach it to all available filesystems
                foreach ($byName as $filesystemId) {
                    $filesystem = $container->getDefinition($filesystemId);
                    $filesystem->addMethodCall('addPlugin', array(new Reference($pluginId)));
                }
            }
        }
    }
}