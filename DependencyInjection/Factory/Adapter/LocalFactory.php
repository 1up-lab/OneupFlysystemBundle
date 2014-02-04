<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class LocalFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'local';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.local'))
            ->replaceArgument(0, $config['directory'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('directory')->isRequired()->end()
            ->end()
        ;
    }
}
