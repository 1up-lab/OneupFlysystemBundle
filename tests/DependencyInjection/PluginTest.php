<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class PluginTest extends ContainerAwareTestCase
{
    public function testIfSinglePluginIsAttached(): void
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = self::$container->get('oneup_flysystem.myfilesystem_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertIsArray($plugins);

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }

    public function testIfAllPluginsAreAttachedCorrectly(): void
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = self::$container->get('oneup_flysystem.myfilesystem2_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertIsArray($plugins);
        $this->assertCount(2, $plugins);

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }

    public function testIfGlobalPluginIsAttached(): void
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = self::$container->get('oneup_flysystem.myfilesystem3_filesystem');

        $refl = new \ReflectionObject($filesystem);
        $property = $refl->getProperty('plugins');
        $property->setAccessible(true);

        $plugins = $property->getValue($filesystem);

        $this->assertIsArray($plugins);
        $this->assertCount(1, $plugins);

        foreach ($plugins as $plugin) {
            $this->assertTrue($plugin instanceof PluginInterface);
        }
    }
}
