<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\DependencyInjection;

use League\Flysystem\FilesystemAdapter;
use Oneup\FlysystemBundle\DependencyInjection\Factory\AdapterFactoryInterface;
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
    /** @var array<AdapterFactoryInterface> */
    private array $adapterFactories = [];

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('factories.xml');

        $this->loadFactories($container);

        $configuration = new Configuration($this->adapterFactories);
        $config = $this->processConfiguration($configuration, $configs);

        $loader->load('adapters.xml');
        $loader->load('flysystem.xml');

        foreach ($config['adapters'] as $name => $adapter) {
            $this->createAdapter($name, $adapter, $container);
        }

        foreach ($config['filesystems'] as $name => $filesystem) {
            $this->createFilesystem($name, $filesystem, $container);
        }
    }

    /**
     * @throws \Exception
     */
    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('factories.xml');

        $this->loadFactories($container);

        return new Configuration($this->adapterFactories);
    }

    private function createAdapter(string $name, array $config, ContainerBuilder $container): void
    {
        foreach ($config as $key => $adapter) {
            dump($this->adapterFactories);

            if (\array_key_exists($key, $this->adapterFactories)) {
                $id = sprintf('oneup_flysystem.%s_adapter', $name);
                dump('aaaa');
                $this->adapterFactories[$key]->create($container, $id, $adapter);

                return;
            }
        }

        throw new \LogicException(sprintf('The adapter \'%s\' is not configured.', $name));
    }

    private function createFilesystem(string $name, array $config, ContainerBuilder $container): void
    {
        $id = sprintf('oneup_flysystem.%s_filesystem', $name);

        $tagParams = ['key' => $name];
        if ($config['mount']) {
            $tagParams['mount'] = $config['mount'];
        }

        $options = [];
        if (\array_key_exists('visibility', $config)) {
            $options['visibility'] = $config['visibility'];
        }

        $container
            ->setDefinition($id, new ChildDefinition('oneup_flysystem.filesystem'))
            ->replaceArgument(0, $config['adapter'])
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

        if (method_exists($container, 'registerAliasForArgument')) {
            $aliasName = $name;

            if (!preg_match('~filesystem$~i', $aliasName)) {
                $aliasName .= 'Filesystem';
            }

            $container->registerAliasForArgument($id, FilesystemAdapter::class, $aliasName)->setPublic(false);
        }
    }

    private function loadFactories(ContainerBuilder $container): void
    {
        $this->adapterFactories = $this->getFactories($container, 'oneup_flysystem.adapter_factory');
    }

    private function getFactories(ContainerBuilder $container, string $tag): array
    {
        $factories = [];
        $services = $container->findTaggedServiceIds($tag);
        foreach (array_keys($services) as $id) {
            /** @var FactoryInterface $factory */
            $factory = $container->get($id);
            $factories[(string) str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $factories;
    }
}
