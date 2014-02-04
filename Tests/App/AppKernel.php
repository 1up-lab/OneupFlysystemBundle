<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            //new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            //new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            //new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            //new JMS\SerializerBundle\JMSSerializerBundle($this),

            // bundle to test
            new Oneup\FlysystemBundle\OneupFlysystemBundle(),
        );

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }
}
