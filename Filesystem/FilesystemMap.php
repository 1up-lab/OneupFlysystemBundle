<?php

namespace Oneup\FlysystemBundle\Filesystem;

use League\Flysystem\Filesystem;

class FilesystemMap implements \IteratorAggregate
{
    protected $map;

    public function __construct()
    {
        $this->map = array();
    }

    public function get($name)
    {
        if (!isset($this->map[$name])) {
            throw new \InvalidArgumentException(sprintf('The filesystem \'%s\' is not registered.', $name));
        }

        return $this->map[$name];
    }

    public function add($name, Filesystem $filesystem)
    {
        $this->map[$name] = $filesystem;

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
