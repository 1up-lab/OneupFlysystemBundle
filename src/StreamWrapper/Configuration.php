<?php


namespace Oneup\FlysystemBundle\StreamWrapper;

use League\Flysystem\FilesystemInterface;

class Configuration
{
    /**
     * @var string
     */
    private $protocol;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var array|null
     */
    private $configuration;

    /**
     * Configuration constructor.
     *
     * @param string              $protocol
     * @param FilesystemInterface $filesystem
     * @param array               $configuration
     */
    public function __construct($protocol, FilesystemInterface $filesystem, array $configuration = null)
    {
        $this->protocol = $protocol;
        $this->filesystem = $filesystem;
        $this->configuration = $configuration;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return FilesystemInterface
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return array|null
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
