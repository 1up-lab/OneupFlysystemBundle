<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle\Tests\Model;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContainerAwareTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;
    protected static $container;

    public function setUp(): void
    {
        $this->client = static::createClient();
        self::$container = $this->client->getContainer();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->client);
    }
}
