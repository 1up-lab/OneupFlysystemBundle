<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection;

use League\Flysystem\Config;
use League\Flysystem\FilesystemOperator;
use Oneup\FlysystemBundle\DependencyInjection\Factory\FactoryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OneupFlysystemExtension extends Extension
{
    private ?array $adapterFactories = null;

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('factories.xml');

        $adapterFactories = $this->getFactories($container);

        $configuration = new Configuration($adapterFactories);
        $config = $this->processConfiguration($configuration, $configs);

        $loader->load('adapters.xml');
        $loader->load('flysystem.xml');

        $adapters = [];

        foreach ($config['adapters'] as $name => $adapter) {
            $adapters[$name] = $this->createAdapter($name, $adapter, $container, $adapterFactories);
        }

        foreach ($config['filesystems'] as $name => $filesystem) {
            $this->createFilesystem($name, $filesystem, $container, $adapters);
        }
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('factories.xml');

        $adapterFactories = $this->getFactories($container);

        return new Configuration($adapterFactories);
    }

    private function createAdapter(string $name, array $config, ContainerBuilder $container, array $factories): string
    {
        foreach ($config as $key => $adapter) {
            if (\array_key_exists($key, $factories)) {
                $id = sprintf('oneup_flysystem.%s_adapter', $name);
                $factories[$key]->create($container, $id, $adapter);

                return $id;
            }
        }

        throw new \LogicException(sprintf('The adapter \'%s\' is not configured.', $name));
    }

    private function createFilesystem(string $name, array $config, ContainerBuilder $container, array $adapters): Reference
    {
        if (!\array_key_exists($config['adapter'], $adapters)) {
            throw new \LogicException(sprintf('The adapter \'%s\' is not defined.', $config['adapter']));
        }

        $adapter = $adapters[$config['adapter']];
        $id = sprintf('oneup_flysystem.%s_filesystem', $name);

        $tagParams = ['key' => $name];

        if ($config['mount']) {
            $tagParams['mount'] = $config['mount'];
        }

        $options = [];

        if (\array_key_exists('visibility', $config)) {
            $options[Config::OPTION_VISIBILITY] = $config['visibility'];
        }

        if (\array_key_exists('directory_visibility', $config)) {
            $options[Config::OPTION_DIRECTORY_VISIBILITY] = $config['directory_visibility'];
        }

        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.filesystem'))
            ->replaceArgument(0, new Reference($adapter))
            ->replaceArgument(1, $options)
            ->addTag('oneup_flysystem.filesystem', $tagParams)
            ->setPublic(true)
        ;

        if (!empty($config['alias'])) {
            $container->getDefinition($id)->setPublic(false);

            try {
                $alias = $container->setAlias($config['alias'], $id);
            } catch (InvalidArgumentException $exception) {
                $alias = $container->getAlias($config['alias']);
            }

            $alias->setPublic(true);
        }

        $aliasName = $name;

        if (!preg_match('~filesystem$~i', $aliasName)) {
            $aliasName .= 'Filesystem';
        }

        $container->registerAliasForArgument($id, FilesystemOperator::class, $aliasName)->setPublic(false);

        return new Reference($id);
    }

    private function getFactories(ContainerBuilder $container): array
    {
        return $this->getAdapterFactories($container);
    }

    private function getAdapterFactories(ContainerBuilder $container): array
    {
        if (null !== $this->adapterFactories) {
            return $this->adapterFactories;
        }

        $factories = [];
        $services = $container->findTaggedServiceIds('oneup_flysystem.adapter_factory');

        foreach (array_keys($services) as $id) {
            /** @var FactoryInterface $factory */
            $factory = $container->get($id);
            $factories[(string) str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $this->adapterFactories = $factories;
    }
}
