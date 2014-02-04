<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Cache;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

use Oneup\FlysystemBundle\DependencyInjection\Factory\CacheFactoryInterface;

class NoopFactory implements CacheFactoryInterface
{
    public function getKey()
    {
        return 'noop';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.cache.noop'))
        ;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        // this adapter has no configuration option
    }
}
