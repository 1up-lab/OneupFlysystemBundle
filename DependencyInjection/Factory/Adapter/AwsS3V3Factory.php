<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class AwsS3V3Factory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'awss3v3';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.awss3v3'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['bucket'])
            ->replaceArgument(2, $config['prefix'])
            ->addArgument((array) $config['options'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->defaultNull()->end()
                ->arrayNode('options')->prototype('scalar')->end()
            ->end()
        ;
    }
}
