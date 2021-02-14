<?php

declare(strict_types=1);

namespace Oneup\FlysystemBundle;

use Oneup\FlysystemBundle\DependencyInjection\Compiler\FilesystemPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OneupFlysystemBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new FilesystemPass());
    }
}
