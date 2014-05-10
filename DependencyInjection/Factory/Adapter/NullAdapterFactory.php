<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class NullAdapterFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'nulladapter';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.nulladapter'))
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
            ->end()
        ;
    }
}
