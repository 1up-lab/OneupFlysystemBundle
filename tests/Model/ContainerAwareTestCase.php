<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\Model;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContainerAwareTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected static $container;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        self::$container = $this->client->getContainer();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->client);
    }
}
