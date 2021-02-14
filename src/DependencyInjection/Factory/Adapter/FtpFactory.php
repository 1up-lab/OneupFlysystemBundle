<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FtpFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'ftp';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.ftp'))
            ->replaceArgument(0, $config['connectionOptions'])
            ->replaceArgument(1, $config['connectionProvider'])
            ->replaceArgument(2, $config['connectivityChecker'])
            ->replaceArgument(3, $config['visibilityConverter'])
            ->replaceArgument(4, $config['mimeTypeDetector'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('connectionOptions')->isRequired()->end()
                ->scalarNode('connectionProvider')->defaultNull()->end()
                ->scalarNode('connectivityChecker')->defaultNull()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
            ->end()
        ;
    }
}
