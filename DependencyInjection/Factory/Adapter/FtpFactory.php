<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class FtpFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'ftp';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.ftp'))
            ->replaceArgument(0, $config)
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('host')->isRequired()->end()

                ->scalarNode('port')->defaultValue(21)->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('root')->defaultNull()->end()
                ->booleanNode('ssl')->defaultFalse()->end()
                ->scalarNode('timeout')->defaultValue(90)->end()
                ->scalarNode('permPrivate')->defaultValue(0000)->end()
                ->scalarNode('permPublic')->defaultNull(0744)->end()
                ->booleanNode('passive')->defaultTrue()->end()
            ->end()
        ;
    }
}
