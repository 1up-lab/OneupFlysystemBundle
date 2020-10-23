<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface FactoryInterface
{
    public function getKey(): string;

    public function create(ContainerBuilder $container, string $id, array $config): void;

    public function addConfiguration(NodeDefinition $builder): void;
}
