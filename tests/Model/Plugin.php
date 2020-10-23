<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\Model;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

class Plugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    public function setFilesystem(FilesystemInterface $filesystem): void
    {
        $this->filesystem = $filesystem;
    }

    public function getMethod(): string
    {
        // we return a unique handler
        // so we can attach this class
        // to multiple filesystems
        return uniqid('', true);
    }

    public function handle(string $path = null): ?string
    {
        return $path;
    }
}
