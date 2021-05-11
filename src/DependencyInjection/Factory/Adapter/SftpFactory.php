<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\PhpseclibV2\SftpConnectionProvider;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

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
            ->replaceArgument(0, (new Definition(SftpConnectionProvider::class))
                ->setFactory([SftpConnectionProvider::class, 'fromArray'])
                ->addArgument($config['options'])
                ->setShared(false)
            )
            ->replaceArgument(1, $config['root'])
            ->replaceArgument(2, $config['visibilityConverter'])
            ->replaceArgument(3, $config['mimeTypeDetector'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('options')->isRequired()
                    ->children()
                        ->scalarNode('host')->isRequired()->end()
                        ->scalarNode('username')->isRequired()->end()
                        ->scalarNode('password')->defaultNull()->end()
                        ->scalarNode('privateKey')->defaultNull()->end()
                        ->scalarNode('passphrase')->defaultNull()->end()
                        ->scalarNode('port')->defaultValue(22)->end()
                        ->booleanNode('useAgent')->defaultFalse()->end()
                        ->scalarNode('timeout')->defaultValue(10)->end()
                        ->scalarNode('maxTries')->defaultValue(4)->end()
                        ->scalarNode('hostFingerprint')->defaultNull()->end()
                        ->scalarNode('connectivity checker')->defaultNull()->end()
                    ->end()
                ->end()
                ->scalarNode('root')->isRequired()->end()
                ->scalarNode('visibilityConverter')->defaultNull()->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
            ->end()
        ;
    }
}
