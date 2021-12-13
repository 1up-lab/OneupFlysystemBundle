<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\DependencyInjection;

use Composer\InstalledVersions;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\StorageAttributes;
use League\Flysystem\Visibility;
use Oneup\FlysystemBundle\DependencyInjection\OneupFlysystemExtension;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OneupFlysystemExtensionTest extends ContainerAwareTestCase
{
    public function testIfTestSuiteLoads(): void
    {
        self::assertTrue(true);
    }

    public function testVisibilitySettings(): void
    {
        /**
         * No visibility flag set.
         *
         * @var Filesystem $filesystem1
         */
        $filesystem1 = $this->getContainer()->get('oneup_flysystem.myfilesystem_filesystem');

        /**
         * Visibility flag is set to "public".
         *
         * @var Filesystem $filesystem2
         */
        $filesystem2 = $this->getContainer()->get('oneup_flysystem.myfilesystem2_filesystem');

        /**
         * Visibility flag is set to "private".
         *
         * @var Filesystem $filesystem3
         */
        $filesystem3 = $this->getContainer()->get('oneup_flysystem.myfilesystem3_filesystem');

        $filesystem1->write('1/meep', 'meep\'s content');
        $filesystem2->write('2/meep', 'meep\'s content');
        $filesystem3->write('3/meep', 'meep\'s content');

        self::assertSame(Visibility::PUBLIC, $filesystem1->visibility('1/meep'));
        self::assertSame(Visibility::PUBLIC, $filesystem2->visibility('2/meep'));
        self::assertSame(Visibility::PRIVATE, $filesystem3->visibility('3/meep'));

        $filesystem1->delete('1/meep');
        $filesystem1->delete('2/meep');
        $filesystem1->delete('3/meep');
    }

    public function testDirectoryVisibilitySettings(): void
    {
        if (version_compare((string) InstalledVersions::getVersion('league/flysystem'), '2.3.1', '<')) {
            $this->markTestSkipped('Flysystem >= 2.3.1 is required (see https://github.com/thephpleague/flysystem/pull/1368).');
        }

        /**
         * No directory visibility flag set, default to "private".
         *
         * @var Filesystem $filesystem5
         */
        $filesystem5 = $this->getContainer()->get('oneup_flysystem.myfilesystem5_filesystem');

        /**
         * Visibility flag is set to "public".
         *
         * @var Filesystem $filesystem6
         */
        $filesystem6 = $this->getContainer()->get('oneup_flysystem.myfilesystem6_filesystem');

        $filesystem5->createDirectory('5');
        $filesystem6->createDirectory('6');

        /** @var DirectoryAttributes $directory5Attributes */
        [$directory5Attributes] = $filesystem5->listContents('')->filter(static fn (StorageAttributes $attributes) => $attributes->isDir() && '5' === $attributes->path())->toArray();
        /** @var DirectoryAttributes $directory6Attributes */
        [$directory6Attributes] = $filesystem5->listContents('')->filter(static fn (StorageAttributes $attributes) => $attributes->isDir() && '6' === $attributes->path())->toArray();

        self::assertSame(Visibility::PRIVATE, $directory5Attributes->visibility());
        self::assertSame(Visibility::PUBLIC, $directory6Attributes->visibility());
    }

    public function testAdapterAvailability(): void
    {
        /** @var \SimpleXMLElement $adapters */
        $adapters = simplexml_load_string((string) file_get_contents(__DIR__ . '/../../src/Resources/config/adapters.xml'));

        foreach ($adapters->children()->children() as $service) {
            if (null === $service->attributes()) {
                continue;
            }

            foreach ($service->attributes() as $key => $attribute) {
                if ('class' === (string) $key) {
                    self::assertTrue(class_exists((string) $attribute), 'Could not load class: ' . $attribute);
                }
            }
        }
    }

    public function testGetConfiguration(): void
    {
        $extension = new OneupFlysystemExtension();
        $configuration = $extension->getConfiguration([], new ContainerBuilder());

        self::assertInstanceOf('Oneup\FlysystemBundle\DependencyInjection\Configuration', $configuration);
    }

    public function testServiceAliasWithFilesystemSuffix(): void
    {
        $container = $this->loadExtension([
            'oneup_flysystem' => [
                'adapters' => [
                    'default_adapter' => [
                        'local' => [
                            'location' => '.',
                            'permissions' => [
                                'file' => [
                                    'public' => '0644',
                                    'private' => '0644',
                                ],
                                'dir' => [
                                    'public' => '0755',
                                    'private' => '0700',
                                ],
                            ],
                        ],
                    ],
                ],
                'filesystems' => [
                    'acme_filesystem' => [
                        'alias' => Filesystem::class,
                        'adapter' => 'default_adapter',
                    ],
                ],
            ],
        ]);

        $aliasName = 'League\Flysystem\FilesystemOperator $acmeFilesystem';

        self::assertTrue($container->hasAlias($aliasName));
        self::assertSame('oneup_flysystem.acme_filesystem_filesystem', (string) $container->getAlias($aliasName));

        self::assertTrue($container->hasAlias(Filesystem::class));
        self::assertSame('oneup_flysystem.acme_filesystem_filesystem', (string) $container->getAlias(Filesystem::class));
    }

    public function testServiceAliasWithoutFilesystemSuffix(): void
    {
        $container = $this->loadExtension([
            'oneup_flysystem' => [
                'adapters' => [
                    'default_adapter' => [
                        'local' => [
                            'location' => '.',
                        ],
                    ],
                ],
                'filesystems' => [
                    'acme' => [
                        'alias' => Filesystem::class,
                        'adapter' => 'default_adapter',
                    ],
                ],
            ],
        ]);

        $aliasName = 'League\Flysystem\FilesystemOperator $acmeFilesystem';

        self::assertTrue($container->hasAlias($aliasName));
        self::assertSame('oneup_flysystem.acme_filesystem', (string) $container->getAlias($aliasName));

        self::assertTrue($container->hasAlias(Filesystem::class));
        self::assertSame('oneup_flysystem.acme_filesystem', (string) $container->getAlias(Filesystem::class));
    }

    public function testServiceAliasInjection(): void
    {
        /** @var TestService $testService */
        $testService = $this->getContainer()->get(TestService::class);

        self::assertInstanceOf(TestService::class, $testService);
        self::assertInstanceOf(Filesystem::class, $testService->filesystem);
    }

    public function testGoogleCloudAdapter(): void
    {
        $this->assertInstanceOf(Filesystem::class, $this->getContainer()->get('oneup_flysystem.myfilesystem4_filesystem'));
    }

    private function loadExtension(array $config): ContainerBuilder
    {
        $extension = new OneupFlysystemExtension();
        $extension->load($config, $container = new ContainerBuilder());

        return $container;
    }
}

/**
 * @internal
 */
final class TestService
{
    public FilesystemOperator $filesystem;

    public function __construct(FilesystemOperator $myfilesystem)
    {
        $this->filesystem = $myfilesystem;
    }
}
