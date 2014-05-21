<?php

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use League\Flysystem\AdapterInterface;

class AwsS3Factory implements AdapterFactoryInterface
{
    public function getKey()
    {
        return 'awss3';
    }

    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.adapter.awss3'))
            ->replaceArgument(0, new Reference($config['client']))
            ->replaceArgument(1, $config['bucket'])
            ->replaceArgument(2, $config['prefix'])
        ;

        $options = array();
        if (isset($config['visibility'])) {
            $options['visibility'] = $config['visibility'];
        }

        $definition->replaceArgument(3, $options);
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $supportedVisibilities = array(
            AdapterInterface::VISIBILITY_PRIVATE,
            AdapterInterface::VISIBILITY_PUBLIC
        );

        $node
            ->children()
                ->scalarNode('client')->isRequired()->end()
                ->scalarNode('bucket')->isRequired()->end()
                ->scalarNode('prefix')->defaultNull()->end()
                ->scalarNode('visibility')
                    ->validate()
                    ->ifNotInArray($supportedVisibilities)
                    ->thenInvalid('The visibility %s is not supported. Please choose one of '.json_encode($supportedVisibilities))
                ->end()
            ->end()
        ;
    }
}
