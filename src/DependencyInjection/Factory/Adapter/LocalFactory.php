<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class LocalFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'local';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $visibilityConverter = null;

        if (isset($config['permissions']) && null !== $config['permissions']) {
            $visibilityConverter = new Definition(PortableVisibilityConverter::class);
            $visibilityConverter->setFactory([PortableVisibilityConverter::class, 'fromArray']);
            $visibilityConverter->setArgument(0, $config['permissions']);
        }

        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.local'))
            ->setLazy($config['lazy'])
            ->replaceArgument(0, $config['location'])
            ->replaceArgument(1, $visibilityConverter)
            ->replaceArgument(2, $config['writeFlags'])
            ->replaceArgument(3, $config['linkHandling'])
            ->replaceArgument(4, $config['mimeTypeDetector'])
            ->replaceArgument(5, $config['lazyRootCreation'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $parseOctal = \Closure::fromCallable([self::class, 'parseOctal']);

        $node
            ->children()
                ->booleanNode('lazy')->defaultValue(false)->end()
                ->scalarNode('location')->isRequired()->end()
                ->arrayNode('permissions')
                    ->children()
                        ->arrayNode('file')
                            ->children()
                                ->integerNode('public')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then($parseOctal)
                                    ->end()
                                    ->defaultNull()
                                ->end()
                                ->integerNode('private')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then($parseOctal)
                                    ->end()
                                    ->defaultNull()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('dir')
                            ->children()
                                ->integerNode('public')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then($parseOctal)
                                    ->end()
                                    ->defaultNull()
                                ->end()
                                ->integerNode('private')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then($parseOctal)
                                    ->end()
                                    ->defaultNull()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('writeFlags')->defaultValue(\LOCK_EX)->end()
                ->scalarNode('linkHandling')->defaultValue(LocalFilesystemAdapter::DISALLOW_LINKS)->end()
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
                ->scalarNode('lazyRootCreation')->defaultValue(false)->end()
            ->end()
        ;
    }

    /**
     * Backward compatibility (BC) between symfony/yaml <= 5.4 and >= 6.0.
     *
     * @see https://github.com/symfony/symfony/pull/34813
     */
    private static function parseOctal(string $scalar): int
    {
        if (!preg_match('/^(?:\+|-)?0o?(?P<value>[0-7_]++)$/', $scalar, $matches)) {
            throw new \InvalidArgumentException("The scalar \"$scalar\" is not a valid octal number.");
        }

        $value = str_replace('_', '', $matches['value']);

        if ('-' === $scalar[0]) {
            return (int) -octdec($value);
        }

        return (int) octdec($value);
    }
}
