<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SftpFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'sftp';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.sftp'))
            ->replaceArgument(0, $config['connectionProvider'])
            ->replaceArgument(1, $config['root'])
            ->replaceArgument(2, $config['visibilityConverter'])
            ->replaceArgument(3, $config['mimeTypeDetector'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('connectionProvider')->isRequired()->end()
                ->scalarNode('root')->isRequired()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
            ->end()
        ;
    }
}
