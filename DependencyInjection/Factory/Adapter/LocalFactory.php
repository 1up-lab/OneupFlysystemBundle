<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use League\Flysystem\Adapter\Local;

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
            ->replaceArgument(1, $config['writeFlags'])
            ->replaceArgument(2, $config['linkHandling'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('directory')->isRequired()->end()
                ->scalarNode('writeFlags')->defaultValue(LOCK_EX)->end()
                ->scalarNode('linkHandling')->defaultValue(Local::DISALLOW_LINKS)->end()
            ->end()
        ;
    }
}
