<?php

namespace Oneup\FlysystemBundle\Tests\DependencyInjection;

use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class OneupFlysystemExtensionTest extends ContainerAwareTestCase
{
    public function testIfTestSuiteLoads()
    {
        $this->assertTrue(true);
    }

    public function testVisibilitySettings()
    {
        /**
         * No visibility flag set.
         *
         * @var Filesystem $filesystem1
         */
        $filesystem1 = $this->container->get('oneup_flysystem.myfilesystem_filesystem');

        /**
         * Visibility flag is set to "public"
         *
         * @var Filesystem $filesystem1
         */
        $filesystem2 = $this->container->get('oneup_flysystem.myfilesystem2_filesystem');

        /**
         * Visibility flag ist set to "private"
         *
         * @var Filesystem $filesystem1
         */
        $filesystem3 = $this->container->get('oneup_flysystem.myfilesystem3_filesystem');

        $filesystem1->write('1/meep', 'meep\'s content');
        $filesystem2->write('2/meep', 'meep\'s content');
        $filesystem3->write('3/meep', 'meep\'s content');

        $this->assertEquals(AdapterInterface::VISIBILITY_PUBLIC, $filesystem1->getVisibility('1/meep'));
        $this->assertEquals(AdapterInterface::VISIBILITY_PUBLIC, $filesystem2->getVisibility('2/meep'));
        $this->assertEquals(AdapterInterface::VISIBILITY_PRIVATE, $filesystem3->getVisibility('3/meep'));
    }

    public function testIfMountManagerIsFilled()
    {
        /** @var MountManager $mountManager */
        $mountManager = $this->container->get('oneup_flysystem.mount_manager');

        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('prefix'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testIfOnlyConfiguredFilesystemsAreMounted()
    {
        /** @var MountManager $mountManager */
        $mountManager = $this->container->get('oneup_flysystem.mount_manager');

        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('prefix2'));
        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('unrelated'));
    }

    public function testAdapterAvailability()
    {
        /** @var \SimpleXMLElement $adapters */
        $adapters = simplexml_load_file(__DIR__.'/../../Resources/config/adapters.xml');

        foreach ($adapters->children()->children() as $service) {
            foreach ($service->attributes() as $key => $attribute) {
                // skip awss3v2 test - it's still BETA
                if ('id' === (string) $key && 'oneup_flysystem.adapter.awss3v3' === (string) $attribute) {
                    break;
                }

                if ('class' === (string) $key) {
                    $this->assertTrue(class_exists((string) $attribute), 'Could not load class: '.(string) $attribute);
                }
            }
        }
    }

    /**
     * Checks if a filesystem with configured cached is from type CachedAdapter.
     */
    public function testIfCachedAdapterAreCached()
    {
        $filesystem = $this->container->get('oneup_flysystem.myfilesystem_filesystem');
        $adapter = $filesystem->getAdapter();

        $this->assertInstanceOf('League\Flysystem\Cached\CachedAdapter', $adapter);
    }
}
