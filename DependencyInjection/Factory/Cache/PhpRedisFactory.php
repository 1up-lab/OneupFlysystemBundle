<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Cache;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Reference;
use Oneup\FlysystemBundle\DependencyInjection\Factory\CacheFactoryInterface;

class PhpRedisFactory implements CacheFactoryInterface
{
    public function getKey()
    {
        return 'php_redis';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.cache.php_redis'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['key'])
            ->replaceArgument(2, $config['expires'])
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('key')->defaultValue('flysystem')->end()
                ->scalarNode('expires')->defaultNull()->end()
            ->end()
        ;
    }
}
