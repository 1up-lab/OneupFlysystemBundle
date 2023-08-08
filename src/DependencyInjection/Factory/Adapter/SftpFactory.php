<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter;

use League\Flysystem\PhpseclibV3\SftpConnectionProvider;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class SftpFactory implements AdapterFactoryInterface
{
    public function getKey(): string
    {
        return 'sftp';
    }

    public function create(ContainerBuilder $container, string $id, array $config): void
    {
        $root = $config['options']['root'];
        unset($config['options']['root']);

        if (null !== $config['options']['connectivityChecker']) {
            $config['options']['connectivityChecker'] = new Reference($config['options']['connectivityChecker']);
        }

        $visibilityConverter = null;

        if (isset($config['permissions'])) {
            $visibilityConverter = new Definition(PortableVisibilityConverter::class);
            $visibilityConverter->setFactory([PortableVisibilityConverter::class, 'fromArray']);
            $visibilityConverter->setArgument(0, $config['permissions']);
        }

        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.adapter.sftp'))
            ->replaceArgument(0, (new Definition(SftpConnectionProvider::class))
                ->setFactory([SftpConnectionProvider::class, 'fromArray'])
                ->addArgument($config['options'])
                ->setShared(false)
            )
            ->replaceArgument(1, $root)
            ->replaceArgument(2, $visibilityConverter)
            ->replaceArgument(3, $config['mimeTypeDetector'])
        ;
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        $parseOctal = \Closure::fromCallable([self::class, 'parseOctal']);

        $node
            ->children()
                ->arrayNode('options')->isRequired()
                    ->children()
                        ->scalarNode('host')->isRequired()->end()
                        ->scalarNode('username')->isRequired()->end()
                        ->scalarNode('password')->defaultNull()->end()
                        ->scalarNode('privateKey')->defaultNull()->end()
                        ->scalarNode('passphrase')->defaultNull()->end()
                        ->scalarNode('port')->defaultValue(22)->end()
                        ->booleanNode('useAgent')->defaultFalse()->end()
                        ->scalarNode('timeout')->defaultValue(10)->end()
                        ->scalarNode('maxTries')->defaultValue(4)->end()
                        ->scalarNode('hostFingerprint')->defaultNull()->end()
                        ->scalarNode('connectivityChecker')->defaultNull()->end()
                        ->scalarNode('root')->isRequired()->end()
                    ->end()
                ->end()
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
                ->scalarNode('mimeTypeDetector')->defaultNull()->end()
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
