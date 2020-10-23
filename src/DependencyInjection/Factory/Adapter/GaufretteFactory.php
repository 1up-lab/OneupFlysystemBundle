<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GaufretteFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'gaufrette';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.gaufrette'))
            ->replaceArgument(0, new Reference($config['adapter']))
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('adapter')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
