<?php

namespace Oneup\FlysystemBundle\Tests\Model;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

class Plugin implements PluginInterface
{
    /** @var FilesystemInterface $filesystem */
    protected $filesystem;

    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getMethod()
    {
        // we return a unique handler
        // so we can attach this class
        // to multiple filesystems
        return uniqid();
    }

    public function handle($path = null)
    {
        return $path;
    }
}
