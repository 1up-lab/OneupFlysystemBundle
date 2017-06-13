<?php

namespace Oneup\FlysystemBundle\Tests\DependencyInjection;

use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Oneup\FlysystemBundle\StreamWrapper\StreamWrapperManager;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;
use Oneup\FlysystemBundle\DependencyInjection\OneupFlysystemExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
         * @var Filesystem $filesystem2
         */
        $filesystem2 = $this->container->get('oneup_flysystem.myfilesystem2_filesystem');

        /**
         * Visibility flag ist set to "private"
         *
         * @var Filesystem $filesystem3
         */
        $filesystem3 = $this->container->get('oneup_flysystem.myfilesystem3_filesystem');

        $filesystem1->write('1/meep', 'meep\'s content');
        $filesystem2->write('2/meep', 'meep\'s content');
        $filesystem3->write('3/meep', 'meep\'s content');

        $this->assertEquals(AdapterInterface::VISIBILITY_PUBLIC, $filesystem1->getVisibility('1/meep'));
        $this->assertEquals(AdapterInterface::VISIBILITY_PUBLIC, $filesystem2->getVisibility('2/meep'));
        $this->assertEquals(AdapterInterface::VISIBILITY_PRIVATE, $filesystem3->getVisibility('3/meep'));
    }

    public function testDisableAssertsSetting()
    {
        /**
         * Enabled asserts.
         *
         * @var Filesystem $filesystem1
         */
        $filesystem1 = $this->container->get('oneup_flysystem.myfilesystem_filesystem');

        /**
         * Disabled asserts
         *
         * @var Filesystem $filesystem2
         */
        $filesystem2 = $this->container->get('oneup_flysystem.myfilesystem2_filesystem');

        $this->assertFalse($filesystem1->getConfig()->get('disable_asserts'));
        $this->assertTrue($filesystem2->getConfig()->get('disable_asserts'));
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

    public function testGetConfiguration()
    {
        $extension = new OneupFlysystemExtension();
        $configuration = $extension->getConfiguration([], new ContainerBuilder());
        $this->assertInstanceOf('Oneup\FlysystemBundle\DependencyInjection\Configuration', $configuration);
    }

    public function testIfNoStreamWrappersConfiguration()
    {
        $container = $this->loadExtension([]);

        $this->assertFalse($container->hasDefinition('oneup_flysystem.stream_wrapper.manager'));
    }

    /**
     * @dataProvider provideDefectiveStreamWrapperConfigurations
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     *
     * @param array $streamWrapperConfig
     */
    public function testIfDefectiveStreamWrapperConfiguration(array $streamWrapperConfig)
    {
        $this->loadExtension([
            'oneup_flysystem' => [
                'adapters' => [
                    'myadapter' => ['local' => ['directory' => '/path/to/mount-point']],
                ],
                'filesystems' => [
                    'myfilesystem' => [
                        'adapter' => 'myadapter',
                        'stream_wrapper' => $streamWrapperConfig,
                    ],
                ],
            ],
        ]);
    }

    public function provideDefectiveStreamWrapperConfigurations()
    {
        $config = [
            'permissions' => [
                'dir' => [
                    'private' => 0700,
                    'public' => 0744,
                ],
                'file' => [
                    'private' => 0700,
                    'public' => 0744,
                ],
            ],
            'metadata' => ['visibility'],
            'public_mask' => 0044,
        ];

        return [
            // empty configuration
            [['protocol' => 'myadapter', 'configuration' => null]],
            [['protocol' => 'myadapter', 'configuration' => []]],
            // missing permissions
            [['protocol' => 'myadapter', 'configuration' => array_merge($config, ['permissions' => null])]],
            // missing metadata
            [['protocol' => 'myadapter', 'configuration' => array_merge($config, ['metadata' => null])]],
            [['protocol' => 'myadapter', 'configuration' => array_merge($config, ['metadata' => []])]],
            // missing public mask
            [['protocol' => 'myadapter', 'configuration' => array_merge($config, ['public_mask' => null])]],
        ];
    }

    /**
     * @dataProvider provideStreamWrapperConfigurationTests
     *
     * @param       $protocol
     * @param array $configuration
     * @param       $streamWrapperConfig
     */
    public function testStreamWrapperConfiguration($protocol, array $configuration = null, $streamWrapperConfig)
    {
        $container = $this->loadExtension([
            'oneup_flysystem' => [
                'adapters' => [
                    'myadapter' => ['local' => ['directory' => '/path/to/mount-point']],
                ],
                'filesystems' => [
                    'myfilesystem' => [
                        'adapter' => 'myadapter',
                        'stream_wrapper' => $streamWrapperConfig,
                    ],
                ],
            ],
        ]);

        $definition = $container->getDefinition('oneup_flysystem.stream_wrapper.configuration.myfilesystem');
        $this->assertEquals($protocol, $definition->getArgument(0));
        $this->assertEquals($configuration, $definition->getArgument(2));
    }

    public function provideStreamWrapperConfigurationTests()
    {
        $config = [
            'permissions' => [
                'dir' => [
                    'private' => 0700,
                    'public' => 0744,
                ],
                'file' => [
                    'private' => 0700,
                    'public' => 0744,
                ],
            ],
            'metadata' => ['visibility'],
            'public_mask' => 0044,
        ];

        return [
            ['myfilesystem', null, 'myfilesystem'],
            ['myfilesystem', null, ['protocol' => 'myfilesystem']],
            ['myfilesystem', $config, ['protocol' => 'myfilesystem', 'configuration' => $config]],
        ];
    }

    public function testStreamWrapperSettings()
    {
        /* @var StreamWrapperManager $manager */
        $manager = $this->container->get('oneup_flysystem.stream_wrapper.manager');

        $this->assertTrue($manager->hasConfiguration('myfilesystem'));
        $this->assertInstanceOf('Oneup\FlysystemBundle\StreamWrapper\Configuration', $configuration = $manager->getConfiguration('myfilesystem'));
        $this->assertFalse($manager->hasConfiguration('myfilesystem2'));
        $this->assertFalse($manager->hasConfiguration('myfilesystem3'));
    }

    /**
     * @param array $config
     *
     * @return ContainerBuilder
     */
    private function loadExtension(array $config)
    {
        $extension = new OneupFlysystemExtension();
        $extension->load($config, $container = new ContainerBuilder());

        return $container;
    }
}
