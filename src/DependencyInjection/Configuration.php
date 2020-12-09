<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection;

use League\Flysystem\Visibility;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected array $adapterFactories;

    public function __construct(array $adapterFactories)
    {
        $this->adapterFactories = $adapterFactories;
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('oneup_flysystem');
        $rootNode = $treeBuilder->getRootNode();

        $this->addAdapterSection($rootNode);
        $this->addFilesystemSection($rootNode);

        $rootNode
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addAdapterSection(ArrayNodeDefinition $node): void
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

    private function addFilesystemSection(ArrayNodeDefinition $node): void
    {
        $supportedVisibilities = [
            Visibility::PRIVATE,
            Visibility::PUBLIC,
        ];

        $node
            ->fixXmlConfig('filesystem')
            ->children()
                ->arrayNode('filesystems')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('adapter')->isRequired()->end()
                        ->scalarNode('alias')->defaultNull()->end()
                        ->scalarNode('mount')->defaultNull()->end()
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
