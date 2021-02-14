<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AwsS3V3Factory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'awss3v3';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.awss3v3'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['bucket'])
            ->replaceArgument(2, $config['prefix'])
            ->replaceArgument(3, $config['visibilityConverter'])
            ->replaceArgument(4, $config['mimeTypeDetector'])
            ->replaceArgument(5, (array) $config['options'])
            ->replaceArgument(6, $config['streamReads'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->defaultNull()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
                ->arrayNode('options')
                    ->scalarPrototype()->end()
                ->end()
                ->booleanNode('streamReads')->defaultTrue()->end()
            ->end()
        ;
    }
}
