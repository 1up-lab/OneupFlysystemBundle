<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\Model;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

class ContainerAwareTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        if (property_exists($this, 'container')) {
            /* @phpstan-ignore-next-line */
            self::$container = $this->client->getContainer();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->client);
    }

    /**
     * BC layer: to be removed once sf <5.3 will not be supported anymore.
     */
    protected static function getContainer(): Container
    {
        if (\is_callable('parent::getContainer')) {
            /* @phpstan-ignore-next-line */
            return parent::getContainer();
        }

        /* @phpstan-ignore-next-line */
        return self::$container;
    }
}
