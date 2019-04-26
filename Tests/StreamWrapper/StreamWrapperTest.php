<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\StreamWrapper;

use League\Flysystem\FilesystemInterface;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class StreamWrapperTest extends ContainerAwareTestCase
{
    public function tearDown(): void
    {
        $this->assertContains('myfilesystem', stream_get_wrappers());

        // shutdown kernel
        parent::tearDown();

        $this->assertNotContains('myfilesystem', stream_get_wrappers());
    }

    public function testStreamWrapperForMyFilesystem(): void
    {
        $this->markTestSkipped('Undefined index: OneupFlysystemBundle/Tests/StreamWrapper/StreamWrapperTest.php:19');

        $path = 'stream-wrapper-test';
        $uri = 'myfilesystem://' . $path;
        $content = 'myfilesystem-stream-wrapper-test';

        $this->assertNotFalse(file_put_contents($uri, $content), 'Can write content via stream wrapper');
        $this->assertSame($content, file_get_contents($uri), 'Can read content via stream wrapper');

        /* @var FilesystemInterface $filesystem */
        $filesystem = $this->client->getContainer()->get('oneup_flysystem.myfilesystem_filesystem');

        $this->assertTrue($filesystem->has($path));
        $this->assertSame($content, stream_get_contents($filesystem->readStream($path)));
    }
}
