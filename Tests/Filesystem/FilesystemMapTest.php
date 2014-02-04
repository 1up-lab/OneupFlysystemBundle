<?php

namespace Oneup\FlysystemBundle\Tests\Filesystem;

use Oneup\FlysystemBundle\Filesystem\FilesystemMap;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class FlysystemMapTest extends ContainerAwareTestCase
{
    public function testIfMapIsRetrievable()
    {
        $this->assertTrue($this->container->has('oneup_flysystem.filesystem_map'));
        $this->assertInstanceOf('Oneup\FlysystemBundle\Filesystem\FilesystemMap', $this->getMap());
    }

    public function testIfMapIsIteratable()
    {
        $this->assertInstanceOf('\Traversable', $this->getMap());
    }

    public function testIfMapContainsFilesystems()
    {
        foreach ($this->getMap() as $filesystem) {
            $this->assertInstanceOf('League\Flysystem\Filesystem', $filesystem);
        }
    }

    public function testIfEmptyMapIsCreatable()
    {
        // if no error happens, the test is successfull
        $map = new FilesystemMap();
    }

    public function testIfEmptyMapCanBeFilled()
    {
        $map = new FilesystemMap();

        foreach (array('foo', 'bar', 'baz') as $name) {
            $mock = $this->getMockBuilder('League\Flysystem\Filesystem')
                ->disableOriginalConstructor()
                ->getMock()
            ;

            $map->add($name, $mock);
        }

        $this->assertInstanceOf('League\Flysystem\Filesystem', $map->get('foo'));
        $this->assertInstanceOf('League\Flysystem\Filesystem', $map->get('bar'));
        $this->assertInstanceOf('League\Flysystem\Filesystem', $map->get('baz'));
    }

    private function getMap()
    {
        return $this->container->get('oneup_flysystem.filesystem_map');
    }
}
