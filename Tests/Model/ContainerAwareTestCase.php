<?php

namespace Oneup\FlysystemBundle\Tests\Model;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContainerAwareTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;
    protected static $container;

    public function setUp()
    {
        $this->client = static::createClient();
        self::$container = $this->client->getContainer();
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->client);
    }
}
