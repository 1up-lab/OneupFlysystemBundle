<?php

namespace Oneup\FlysystemBundle\Tests\DependencyInjection;

use League\Flysystem\MountManager;
use Oneup\FlysystemBundle\Tests\Model\ContainerAwareTestCase;

class OneupFlysystemExtensionTest extends ContainerAwareTestCase
{
    public function testIfTestSuiteLoads()
    {
        $this->assertTrue(true);
    }

    public function testIfMountManagerIsFilled()
    {
        /** @var MountManager $mountManager */
        $mountManager = $this->container->get('oneup_flysystem.mount_manager');

        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('prefix'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testIfOnlyConfiguredFilesystemsAreMounted()
    {
        /** @var MountManager $mountManager */
        $mountManager = $this->container->get('oneup_flysystem.mount_manager');

        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('prefix2'));
        $this->assertInstanceOf('League\Flysystem\Filesystem', $mountManager->getFilesystem('unrelated'));
    }
}
