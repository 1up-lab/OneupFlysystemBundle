<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Cache;

use Oneup\FlysystemBundle\DependencyInjection\Factory\CacheFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MemoryFactory implements CacheFactoryInterface
{
    public function getKey(): string
    {
        return 'memory';
    }

    public function create(ContainerBuilder $container, $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.cache.memory'))
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        // this adapter has no configuration option
    }
}
