<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AsyncAwsS3Factory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'async_aws_s3';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.async_aws_s3'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['bucket'])
            ->replaceArgument(2, $config['prefix'])
            ->replaceArgument(3, $config['visibilityConverter'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->treatNullLike('')->defaultValue('')->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
            ->end()
        ;
    }
}
