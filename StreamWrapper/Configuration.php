<?php

declare(strict_types=1);

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

    public function getProtocol(): string
    {
        return $this->protocol;
    }

    public function getFilesystem(): FilesystemInterface
    {
        return $this->filesystem;
    }

    public function getConfiguration(): ?array
    {
        return $this->configuration;
    }
}
