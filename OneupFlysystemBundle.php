<?php

namespace Oneup\FlysystemBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Oneup\FlysystemBundle\DependencyInjection\Compiler\FilesystemPass;

class OneupFlysystemBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FilesystemPass());
    }
}
