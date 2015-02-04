<?php

namespace Oneup\FlysystemBundle\Tests;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class PluginTest extends ContainerAwareTestCase
{
    public function testIfSinglePluginIsAttached()
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = $this->container->get('oneup_flysystem.myfilesystem_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertTrue(is_array($plugins));

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }

    public function testIfAllPluginsAreAttachedCorrectly()
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = $this->container->get('oneup_flysystem.myfilesystem2_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertTrue(is_array($plugins));
        $this->assertCount(2, $plugins);

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }

    public function testIfGlobalPluginIsAttached()
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = $this->container->get('oneup_flysystem.myfilesystem3_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertTrue(is_array($plugins));
        $this->assertCount(1, $plugins);

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }
}
