<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FallbackFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'fallback';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.fallback'))
            ->replaceArgument(0, new Reference(sprintf('oneup_flysystem.%s_adapter', $config['mainAdapter'])))
            ->replaceArgument(1, new Reference(sprintf('oneup_flysystem.%s_adapter', $config['fallback'])))
            ->replaceArgument(2, $config['forceCopyOnMain'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('mainAdapter')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('fallback')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('forceCopyOnMain')->defaultFalse()->end()
            ->end()
        ;
    }
}
