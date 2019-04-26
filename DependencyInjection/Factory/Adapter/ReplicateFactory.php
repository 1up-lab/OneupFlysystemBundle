<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReplicateFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'replicate';
    }

    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.replicate'))
            ->replaceArgument(0, new Reference(sprintf('oneup_flysystem.%s_adapter', $config['sourceAdapter'])))
            ->replaceArgument(1, new Reference(sprintf('oneup_flysystem.%s_adapter', $config['replicaAdapter'])))
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('sourceAdapter')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('replicaAdapter')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
