<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
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
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.local'))
            ->setLazy($config['lazy'])
            ->replaceArgument(0, $config['directory'])
            ->replaceArgument(1, $config['writeFlags'])
            ->replaceArgument(2, $config['linkHandling'])
            ->replaceArgument(3, $config['permissions'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->booleanNode('lazy')->defaultValue(false)->end()
                ->scalarNode('directory')->isRequired()->end()
                ->scalarNode('writeFlags')->defaultValue(LOCK_EX)->end()
                ->scalarNode('linkHandling')->defaultValue(Local::DISALLOW_LINKS)->end()
                ->arrayNode('permissions')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('file')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('public')->defaultValue(0644)->end()
                                ->scalarNode('private')->defaultValue(0600)->end()
                            ->end()
                        ->end()
                        ->arrayNode('dir')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('public')->defaultValue(0755)->end()
                                ->scalarNode('private')->defaultValue(0700)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
