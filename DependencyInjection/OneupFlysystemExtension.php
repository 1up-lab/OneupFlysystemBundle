<?php

namespace Oneup\FlysystemBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OneupFlysystemExtension extends Extension
{
    private $adapterFactories;
    private $cacheFactories;

    public function load(array $configs, ContainerBuilder $container)
    {
        list($adapterFactories, $cacheFactories) = $this->getFactories();

        $configuration = new Configuration($adapterFactories, $cacheFactories);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('adapters.xml');
        $loader->load('flysystem.xml');
        $loader->load('cache.xml');

        $adapters = array();
        $filesystems = array();
        $caches = array();

        foreach ($config['adapters'] as $name => $adapter) {
            $adapters[$name] = $this->createAdapter($name, $adapter, $container, $adapterFactories);
        }

        foreach ($config['cache'] as $name => $cache) {
            $caches[$name] = $this->createCache($name, $cache, $container, $cacheFactories);
        }

        foreach ($config['filesystems'] as $name => $filesystem) {
            $filesystems[$name] = $this->createFilesystem($name, $filesystem, $container, $adapters, $caches);
        }
    }

    private function createCache($name, array $config, ContainerBuilder $container, array $factories)
    {
        foreach ($config as $key => $adapter) {
            if (array_key_exists($key, $factories)) {
                $id = sprintf('oneup_flysystem.%s_cache', $name);
                $factories[$key]->create($container, $id, $adapter);

                return $id;
            }
        }

        throw new \LogicException(sprintf('The cache \'%s\' is not configured.', $name));
    }

    private function createAdapter($name, array $config, ContainerBuilder $container, array $factories)
    {
        foreach ($config as $key => $adapter) {
            if (array_key_exists($key, $factories)) {
                $id = sprintf('oneup_flysystem.%s_adapter', $name);
                $factories[$key]->create($container, $id, $adapter);

                return $id;
            }
        }

        throw new \LogicException(sprintf('The adapter \'%s\' is not configured.', $name));
    }

    private function createFilesystem($name, array $config, ContainerBuilder $container, array $adapters, array $caches)
    {
        if (!array_key_exists($config['adapter'], $adapters)) {
            throw new \LogicException(sprintf('The adapter \'%s\' is not defined.', $config['adapter']));
        }

        $adapter = $adapters[$config['adapter']];
        $id = sprintf('oneup_flysystem.%s_filesystem', $name);

        $cache = null;
        if (array_key_exists($config['cache'], $caches)) {
            $cache = new Reference($caches[$config['cache']]);
        }

        $tagParams = array('key' => $name);

        if ($config['mount']) {
            $tagParams['mount'] = $config['mount'];
        }

        $container
            ->setDefinition($id, new DefinitionDecorator('oneup_flysystem.filesystem'))
            ->replaceArgument(0, new Reference($adapter))
            ->replaceArgument(1, $cache)
            ->addTag('oneup_flysystem.filesystem', $tagParams);
        ;

        if (!empty($config['alias'])) {
            $container->getDefinition($id)->setPublic(false);
            $container->setAlias($config['alias'], $id);
        }

        return new Reference($id);
    }

    private function getFactories()
    {
        // load bundled factories
        $container = new ContainerBuilder();
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('factories.xml');

        return array(
            $this->getAdapterFactories($container),
            $this->getCacheFactories($container)
        );
    }

    private function getAdapterFactories(ContainerBuilder $container)
    {
        if (null !== $this->adapterFactories) {
            return $this->adapterFactories;
        }

        $factories = array();
        $services  = $container->findTaggedServiceIds('oneup_flysystem.adapter_factory');

        foreach (array_keys($services) as $id) {
            $factory = $container->get($id);
            $factories[str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $this->adapterFactories = $factories;
    }

    private function getCacheFactories(ContainerBuilder $container)
    {
        if (null !== $this->cacheFactories) {
            return $this->cacheFactories;
        }

        $factories = array();
        $services  = $container->findTaggedServiceIds('oneup_flysystem.cache_factory');

        foreach (array_keys($services) as $id) {
            $factory = $container->get($id);
            $factories[str_replace('-', '_', $factory->getKey())] = $factory;
        }

        return $this->cacheFactories = $factories;
    }
}
