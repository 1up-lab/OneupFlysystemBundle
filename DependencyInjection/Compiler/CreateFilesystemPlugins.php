<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CreateFilesystemPlugins implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $filesystemPluginServices = $container->findTaggedServiceIds('oneup_flysystem.filesystem_plugin');
        
        $filesystems = array();
        foreach ($container->getExtensionConfig("oneup_flysystem") as $partialConf)
        {
            $filesystems = array_merge($filesystems, array_keys($partialConf["filesystems"]));
        }
        foreach ($filesystems as $filesystem) {
            foreach ($filesystemPluginServices as $filesystemPluginName => $filesystemPluginService)
            {
                $container->getDefinition('oneup_flysystem.'.$filesystem.'_filesystem')->addMethodCall('addPlugin', array(new Reference($filesystemPluginName)));
            }
        }
    }
}

