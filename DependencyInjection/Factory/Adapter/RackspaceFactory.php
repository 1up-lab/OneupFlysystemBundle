<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
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
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.rackspace'))
            ->replaceArgument(0, new Reference($config['container']))
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('container')->isRequired()->end()
            ->end()
        ;
    }
}
