<?php

namespace Oneup\FlysystemBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected $adapterFactories;
    protected $cacheFactories;

    public function __construct(array $adapterFactories, array $cacheFactories)
    {
        $this->adapterFactories = $adapterFactories;
        $this->cacheFactories = $cacheFactories;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oneup_flysystem');

        $this->addCacheSection($rootNode);
        $this->addAdapterSection($rootNode);
        $this->addFilesystemSection($rootNode);

        $rootNode
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addCacheSection(ArrayNodeDefinition $node)
    {
        $cacheNodeBuilder = $node
            ->children()
                ->arrayNode('cache')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->performNoDeepMerging()
                    ->children()
        ;

        foreach ($this->cacheFactories as $name => $factory) {
            $factoryNode = $cacheNodeBuilder->arrayNode($name)->canBeUnset();

            $factory->addConfiguration($factoryNode);
        }
    }

    private function addAdapterSection(ArrayNodeDefinition $node)
    {
        $adapterNodeBuilder = $node
            ->fixXmlConfig('adapter')
            ->children()
                ->arrayNode('adapters')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->performNoDeepMerging()
                    ->children()
        ;

        foreach ($this->adapterFactories as $name => $factory) {
            $factoryNode = $adapterNodeBuilder->arrayNode($name)->canBeUnset();

            $factory->addConfiguration($factoryNode);
        }
    }

    private function addFilesystemSection(ArrayNodeDefinition $node)
    {
        $node
            ->fixXmlConfig('filesystem')
            ->children()
                ->arrayNode('filesystems')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('adapter')->isRequired()->end()
                        ->scalarNode('cache')->defaultNull()->end()
                        ->scalarNode('alias')->defaultNull()->end()
                        ->scalarNode('mount')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
