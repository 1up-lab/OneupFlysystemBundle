<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class GoogleCloudStorageFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'googlecloudstorage';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.googlecloudstorage'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, new Reference($config['bucket']))
            ->replaceArgument(2, $config['prefix'])
            ->replaceArgument(3, $config['storage_api_url'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->defaultNull()->end()
                ->scalarNode('storage_api_url')->defaultNull()->end()
            ->end()
        ;
    }
}
