<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;

class AsyncAwsS3Factory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'async_aws_s3';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
         $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.async_aws_s3'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['bucket'])
            ->replaceArgument(2, $config['prefix'])
            ->addArgument($config['options'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->treatNullLike('')->defaultValue('')->end()
                ->variableNode('options')->treatNullLike([])->defaultValue([])->end()
            ->end()
        ;
    }
}
