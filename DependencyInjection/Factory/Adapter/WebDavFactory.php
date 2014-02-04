<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class WebDavFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'webdav';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.webdav'))
            ->replaceArgument(0, new Reference($config['client']))
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
            ->end()
        ;
    }
}
