<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class FilesystemPluginPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $filesystemPluginServicesAll = $container->findTaggedServiceIds('oneup_flysystem.filesystem_plugin.__all__');

        $filesystems = array();
        foreach ($container->getExtensionConfig("oneup_flysystem") as $partialConf)
        {
            $filesystems = array_merge($filesystems, array_keys($partialConf["filesystems"]));
        }
        foreach ($filesystems as $filesystem)
        {
            $filesystemPluginServicesForThisFs = $container->findTaggedServiceIds('oneup_flysystem.filesystem_plugin.'.$filesystem);
            
            $filesystemPluginServices = array_merge($filesystemPluginServicesAll, $filesystemPluginServicesForThisFs);

            foreach ($filesystemPluginServices as $filesystemPluginName => $filesystemPluginService)
            {
                $container->getDefinition('oneup_flysystem.' . $filesystem . '_filesystem')->addMethodCall('addPlugin', array($container->findDefinition($filesystemPluginName)));
            }
        }
    }
}
