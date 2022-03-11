<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\Ftp\FtpConnectionOptions;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

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
            ->replaceArgument(0,
                (new Definition(FtpConnectionOptions::class))
                    ->setFactory([FtpConnectionOptions::class, 'fromArray'])
                    ->addArgument($config['options'])
                    ->setShared(false)
            )
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
                ->arrayNode('options')
                    ->children()
                        ->scalarNode('host')->isRequired()->end()
                        ->scalarNode('root')->isRequired()->end()
                        ->scalarNode('username')->isRequired()->end()
                        ->scalarNode('password')->isRequired()->end()
                        ->scalarNode('port')->defaultValue(21)->end()
                        ->booleanNode('ssl')->defaultFalse()->end()
                        ->scalarNode('timeout')->defaultValue(90)->end()
                        ->booleanNode('utf8')->defaultFalse()->end()
                        ->booleanNode('passive')->defaultTrue()->end()
                        ->scalarNode('transferMode')->defaultValue(\defined('FTP_BINARY') ? \FTP_BINARY : null)->end()
                        ->scalarNode('systemType')->defaultNull()->end()
                        ->booleanNode('ignorePassiveAddress')->defaultNull()->end()
                        ->booleanNode('timestampsOnUnixListingsEnabled')->defaultFalse()->end()
                        ->booleanNode('recurseManually')->defaultFalse()->end()
                        ->booleanNode('useListOptions')->defaultTrue()->end()
                    ->end()
                ->end()
                ->scalarNode('connectionProvider')->defaultNull()->end()
                ->scalarNode('connectivityChecker')->defaultNull()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
            ->end()
        ;
    }
}
