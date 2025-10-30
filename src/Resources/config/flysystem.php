<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('oneup_flysystem.mount_manager', League\Flysystem\MountManager::class)
    ->public()
    ->args([
        'filesystems',
    ])
    ;

    $services->set('oneup_flysystem.filesystem', League\Flysystem\Filesystem::class)->public()->abstract()
        ->args([
            'adapter',
            'config',
        ])
    ;
};
