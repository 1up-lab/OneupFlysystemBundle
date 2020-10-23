<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Cache;

use Oneup\FlysystemBundle\DependencyInjection\Factory\CacheFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Psr6Factory implements CacheFactoryInterface
{
    public function getKey(): string
    {
        return 'psr6';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.cache.psr6'))
            ->replaceArgument(0, new Reference($config['service']))
            ->replaceArgument(1, $config['key'])
            ->replaceArgument(2, $config['expires'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('service')->isRequired()->end()
                ->scalarNode('key')->defaultValue('flysystem')->end()
                ->scalarNode('expires')->defaultNull()->end()
            ->end()
        ;
    }
}
