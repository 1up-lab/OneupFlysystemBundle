<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CustomAdapterFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'custom';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $container->setAlias($id, $config['service']);
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $node
            ->children()
                ->variableNode('service')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    }
}
