<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\DependencyInjection\Compiler;

use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FilesystemPassTest extends WebTestCase
{
    public function testMountIdentifiers(): void
    {
        /** @var MountManager $mountManager */
        $mountManager = self::getContainer()->get('oneup_flysystem.mount_manager');
        /** @var Filesystem $filesystem1 */
        $filesystem1 = self::getContainer()->get('oneup_flysystem.myfilesystem_filesystem');
        /** @var Filesystem $filesystem2 */
        $filesystem2 = self::getContainer()->get('oneup_flysystem.myfilesystem2_filesystem');

        self::assertFalse($filesystem1->fileExists('foo'));
        self::assertFalse($filesystem2->fileExists('bar'));

        $mountManager->write('myfilesystem://foo', 'foo');
        $mountManager->write('local://bar', 'bar');

        self::assertTrue($filesystem1->fileExists('foo'));
        self::assertTrue($filesystem2->fileExists('bar'));

        $mountManager->delete('myfilesystem://foo');
        $mountManager->delete('local://bar');

        self::assertFalse($filesystem1->fileExists('foo'));
        self::assertFalse($filesystem2->fileExists('bar'));
    }
}
