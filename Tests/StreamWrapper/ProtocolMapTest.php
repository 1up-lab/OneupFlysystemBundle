<?php

namespace Oneup\FlysystemBundle\Tests\StreamWrapper;

use League\Flysystem\FilesystemInterface;
use Oneup\FlysystemBundle\StreamWrapper\ProtocolMap;

class ProtocolMapTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $map = new ProtocolMap();

        $this->assertFalse($map->has('foo'));

        $map->add('foo', $fs = $this->mockFilesystem());

        $this->assertTrue($map->has('foo'));
        $this->assertSame($fs, $map->get('foo'));

        $this->assertEquals([
            'foo' => $fs
        ], iterator_to_array($map));
    }
    
    public function testAddMappingViaConstructor()
    {
        $map = new ProtocolMap([
            'foo' => $fsFoo = $this->mockFilesystem(),
            'bar' => $fsBar = $this->mockFilesystem(),
        ]);

        $this->assertTrue($map->has('foo'));
        $this->assertTrue($map->has('bar'));
        $this->assertSame($fsFoo, $map->get('foo'));
        $this->assertSame($fsBar, $map->get('bar'));

        $this->assertEquals([
            'foo' => $fsFoo,
            'bar' => $fsBar,
        ], iterator_to_array($map));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|FilesystemInterface
     */
    private function mockFilesystem()
    {
        return $this->getMock('League\Flysystem\FilesystemInterface');
    }
}
