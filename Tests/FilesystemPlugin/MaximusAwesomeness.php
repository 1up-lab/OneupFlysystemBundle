<?php

namespace Oneup\FlysystemBundle\Tests\FilesystemPlugin;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

class MaximusAwesomeness implements PluginInterface
{
    protected $filesystem;

    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getMethod()
    {
        return 'getDown';
    }

    public function handle($path = null)
    {
        $contents = $this->filesystem->read($path);

        return sha1($contents);
    }
}