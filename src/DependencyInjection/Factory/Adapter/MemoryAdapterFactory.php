<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MemoryAdapterFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'memory';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.memory'))
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
            ->end()
        ;
    }
}
