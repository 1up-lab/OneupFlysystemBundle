<?php

namespace Oneup\FlysystemBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oneup_flysystem');

        $rootNode
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }
}
