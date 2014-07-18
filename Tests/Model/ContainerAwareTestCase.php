<?php

namespace Oneup\FlysystemBundle\Tests\Model;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContainerAwareTestCase extends WebTestCase
{
    protected $client;
    protected $container;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
    }

    public function tearDown()
    {
        unset($this->client);
        unset($this->container);
    }
}