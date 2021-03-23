<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\Visibility;
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

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.googlecloudstorage'))
            ->replaceArgument(0, $config['bucket'])
            ->replaceArgument(1, $config['prefix'])
            ->replaceArgument(2, $config['visibilityHandler'])
            ->replaceArgument(3, $config['defaultVisiblity'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
            ->scalarNode('bucket')->isRequired()->end()
            ->scalarNode('prefix')->treatNullLike('')->defaultValue('')->end()
            ->scalarNode('visibilityHandler')->defaultNull()->end()
            ->scalarNode('defaultVisiblity')->defaultValue(Visibility::PRIVATE)->end()
            ->end()
        ;
    }
}
