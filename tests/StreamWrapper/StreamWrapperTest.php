<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\StreamWrapper;

use League\Flysystem\FilesystemInterface;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class StreamWrapperTest extends ContainerAwareTestCase
{
    protected function tearDown(): void
    {
        self::assertContains('myfilesystem', stream_get_wrappers());

        // shutdown kernel
        parent::tearDown();

        self::assertNotContains('myfilesystem', stream_get_wrappers());
    }

    public function testStreamWrapperForMyFilesystem(): void
    {
        $path = 'stream-wrapper-test';
        $uri = 'myfilesystem://' . $path;
        $content = 'myfilesystem-stream-wrapper-test';

        self::assertNotFalse(file_put_contents($uri, $content), 'Can write content via stream wrapper');
        self::assertSame($content, file_get_contents($uri), 'Can read content via stream wrapper');

        /** @var FilesystemInterface $filesystem */
        $filesystem = $this->client->getContainer()->get('oneup_flysystem.myfilesystem_filesystem');

        /** @var resource $resource */
        $resource = $filesystem->readStream($path);

        self::assertTrue($filesystem->has($path));
        self::assertSame($content, stream_get_contents($resource));
    }
}
