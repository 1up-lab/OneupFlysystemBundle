<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\Local\LocalFilesystemAdapter;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LocalFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'local';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.local'))
            ->setLazy($config['lazy'])
            ->replaceArgument(0, $config['location'])
            ->replaceArgument(1, $config['visibilityConverter'])
            ->replaceArgument(2, $config['writeFlags'])
            ->replaceArgument(3, $config['linkHandling'])
            ->replaceArgument(4, $config['mimeTypeDetector'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->booleanNode('lazy')->defaultValue(false)->end()
                ->scalarNode('location')->isRequired()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('writeFlags')->defaultValue(\LOCK_EX)->end()
                ->scalarNode('linkHandling')->defaultValue(LocalFilesystemAdapter::DISALLOW_LINKS)->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
            ->end()
        ;
    }
}
