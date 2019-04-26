<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GoogleCloudStorageFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'googlecloudstorage';
    }

    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.googlecloudstorage'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, new Reference($config['bucket']))
            ->replaceArgument(2, $config['prefix'])
            ->replaceArgument(3, $config['storage_api_url'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
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
