<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ZipFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'zip';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $archive = null !== $config['archive'] ? new Reference($config['archive']) : null;

        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.zip'))
            ->replaceArgument(0, $config['location'])
            ->replaceArgument(1, $archive)
            ->replaceArgument(2, $config['prefix'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('location')->isRequired()->end()
                ->scalarNode('archive')->defaultNull()->end()
                ->scalarNode('prefix')->defaultNull()->end()
            ->end()
        ;
    }
}
