<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class SftpFactory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'sftp';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.sftp'))
            ->replaceArgument(0, $config)
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('host')->isRequired()->end()

                ->scalarNode('port')->defaultValue(22)->end()
                ->scalarNode('username')->defaultNull()->end()
                ->scalarNode('password')->defaultNull()->end()
                ->scalarNode('timeout')->defaultValue(90)->end()
                ->scalarNode('root')->defaultNull()->end()
                ->scalarNode('privateKey')->defaultNull()->end()
                ->scalarNode('permPrivate')->defaultValue(0000)->end()
                ->scalarNode('permPublic')->defaultNull(0744)->end()
                ->scalarNode('directoryPerm')->defaultNull()->end()
            ->end()
        ;
    }
}
