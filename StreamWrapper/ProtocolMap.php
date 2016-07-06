<?php


namespace Oneup\FlysystemBundle\StreamWrapper;


use League\Flysystem\FilesystemInterface;

class ProtocolMap implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * ProtocolMap constructor.
     *
     * @param array $map
     */
    public function __construct(array $map = [])
    {
        foreach ($map as $protocol => $filesystem) {
            $this->add($protocol, $filesystem);
        }
    }

    /**
     * @param string              $protocol
     * @param FilesystemInterface $filesystem
     */
    public function add($protocol, FilesystemInterface $filesystem)
    {
        $this->map[$protocol] = $filesystem;
    }

    /**
     * @param string $protocol
     *
     * @return FilesystemInterface
     */
    public function get($protocol)
    {
        if ($this->has($protocol)) {
            return $this->map[$protocol];
        }
        
        throw new \InvalidArgumentException(sprintf('No filesystem register for protocol "%s"', $protocol));
    }

    /**
     * @param string $protocol
     *
     * @return bool
     */
    public function has($protocol)
    {
        return isset($this->map[$protocol]);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}
