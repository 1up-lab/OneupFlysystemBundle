<?php

namespace Oneup\FlysystemBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Oneup\FlysystemBundle\DependencyInjection\Compiler\FilesystemPluginPass;

class OneupFlysystemBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
       $container->addCompilerPass(new FilesystemPluginPass());
    }
}
