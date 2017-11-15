<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class RackspaceFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'rackspace';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.rackspace'))
            ->setLazy($config['lazy'])
            ->replaceArgument(0, new Reference($config['container']))
            ->replaceArgument(1, $config['prefix'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->booleanNode('lazy')->defaultValue(false)->end()
                ->scalarNode('container')->isRequired()->end()
                ->scalarNode('prefix')->defaultNull()->end()
            ->end()
        ;
    }
}
