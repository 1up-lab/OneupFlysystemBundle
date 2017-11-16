<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Cache;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Oneup\FlysystemBundle\DependencyInjection\Factory\CacheFactoryInterface;

class MemoryFactory implements CacheFactoryInterface
{
    public function getKey()
    {
        return 'memory';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.cache.memory'))
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        // this adapter has no configuration option
    }
}
