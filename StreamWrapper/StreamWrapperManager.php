<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\StreamWrapper;

use Twistor\FlysystemStreamWrapper;

class StreamWrapperManager
{
    /**
     * @var Configuration[]
     */
    private $configurations;

    /**
     * StreamWrapperManager constructor.
     *
     * @param Configuration[] $configurations
     */
    public function __construct(array $configurations = [])
    {
        $this->configurations = [];

        foreach ($configurations as $name => $configuration) {
            $this->addConfiguration($name, $configuration);
        }
    }

    /**
     * @param string        $filesystemName
     * @param Configuration $configuration
     */
    public function addConfiguration($filesystemName, Configuration $configuration): void
    {
        $this->configurations[$filesystemName] = $configuration;
    }

    public function hasConfiguration(string $filesystemName): bool
    {
        return isset($this->configurations[$filesystemName]);
    }

    public function getConfiguration(string $filesystemName): Configuration
    {
        if (!$this->hasConfiguration($filesystemName)) {
            throw new \InvalidArgumentException(sprintf('The filesystem "%s" has no stream wrapper configuration', $filesystemName));
        }

        return $this->configurations[$filesystemName];
    }

    /**
     * @throws \Exception
     */
    public function register(): void
    {
        foreach ($this->configurations as $configuration) {
            // Unregister stream wrapper first in case it was already registered.
            FlysystemStreamWrapper::unregister($configuration->getProtocol());

            if (!FlysystemStreamWrapper::register($configuration->getProtocol(), $configuration->getFilesystem(), $configuration->getConfiguration())) {
                throw new \Exception(sprintf('Unable to register stream wrapper protocol "%s://"', $configuration->getProtocol()));
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function unregister(): void
    {
        foreach ($this->configurations as $configuration) {
            if (!FlysystemStreamWrapper::unregister($configuration->getProtocol())) {
                throw new \Exception(sprintf('Unable to unregister stream wrapper protocol "%s://"', $configuration->getProtocol()));
            }
        }
    }
}
