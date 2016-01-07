<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class CustomAdapterFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'custom';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container->setAlias($id, $config['service']);
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
            ->variableNode('service')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
