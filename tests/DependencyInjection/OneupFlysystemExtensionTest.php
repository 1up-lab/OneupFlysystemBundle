<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\DependencyInjection;

use League\Flysystem\Filesystem;
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
        $filesystem1 = self::$container->get('oneup_flysystem.myfilesystem_filesystem');

        /**
         * Visibility flag is set to "public".
         *
         * @var Filesystem $filesystem2
         */
        $filesystem2 = self::$container->get('oneup_flysystem.myfilesystem2_filesystem');

        /**
         * Visibility flag ist set to "private".
         *
         * @var Filesystem $filesystem3
         */
        $filesystem3 = self::$container->get('oneup_flysystem.myfilesystem3_filesystem');

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

    public function testAdapterAvailability(): void
    {
        /** @var \SimpleXMLElement $adapters */
        $adapters = simplexml_load_string((string) file_get_contents(__DIR__ . '/../../src/Resources/config/adapters.xml'));

        foreach ($adapters->children()->children() as $service) {
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

        $aliasName = 'League\Flysystem\FilesystemAdapter $acmeFilesystem';

        self::assertTrue($container->hasAlias($aliasName));
        self::assertSame('oneup_flysystem.acme_filesystem_filesystem', (string) $container->getAlias($aliasName));
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

        $aliasName = 'League\Flysystem\FilesystemAdapter $acmeFilesystem';

        self::assertTrue($container->hasAlias($aliasName));
        self::assertSame('oneup_flysystem.acme_filesystem', (string) $container->getAlias($aliasName));
    }

    private function loadExtension(array $config): ContainerBuilder
    {
        $extension = new OneupFlysystemExtension();
        $extension->load($config, $container = new ContainerBuilder());

        return $container;
    }
}
