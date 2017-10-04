<?php

namespace Oneup\FlysystemBundle\DependencyInjection;

use League\Flysystem\AdapterInterface;
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
        $supportedVisibilities = array(
            AdapterInterface::VISIBILITY_PRIVATE,
            AdapterInterface::VISIBILITY_PUBLIC,
        );

        $node
            ->fixXmlConfig('filesystem')
            ->children()
                ->arrayNode('filesystems')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->booleanNode('disable_asserts')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('plugins')->treatNullLike(array())->prototype('scalar')->end()->end()
                        ->scalarNode('adapter')->isRequired()->end()
                        ->scalarNode('cache')->defaultNull()->end()
                        ->scalarNode('alias')->defaultNull()->end()
                        ->scalarNode('mount')->defaultNull()->end()
                        ->arrayNode('stream_wrapper')
                            ->beforeNormalization()
                                ->ifString()->then(function ($protocol) {
                                    return ['protocol' => $protocol];
                                })
                            ->end()
                            ->children()
                                ->scalarNode('protocol')->isRequired()->end()
                                ->arrayNode('configuration')
                                    ->children()
                                        ->arrayNode('permissions')
                                            ->isRequired()
                                            ->children()
                                                ->arrayNode('dir')
                                                    ->isRequired()
                                                    ->children()
                                                        ->integerNode('private')->isRequired()->end()
                                                        ->integerNode('public')->isRequired()->end()
                                                    ->end()
                                                ->end()
                                                ->arrayNode('file')
                                                    ->isRequired()
                                                    ->children()
                                                        ->integerNode('private')->isRequired()->end()
                                                        ->integerNode('public')->isRequired()->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                        ->arrayNode('metadata')
                                            ->isRequired()
                                            ->requiresAtLeastOneElement()
                                            ->prototype('scalar')->cannotBeEmpty()->end()
                                        ->end()
                                        ->integerNode('public_mask')->isRequired()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('visibility')
                            ->validate()
                            ->ifNotInArray($supportedVisibilities)
                            ->thenInvalid('The visibility %s is not supported.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
