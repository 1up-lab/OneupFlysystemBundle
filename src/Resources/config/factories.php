<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('oneup_flysystem.adapter_factory.local', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\LocalFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.awss3v3', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\AwsS3V3Factory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.ftp', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\FtpFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.sftp', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\SftpFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.in_memory', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\InMemoryFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.customadapter', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\CustomAdapterFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.async_aws_s3', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\AsyncAwsS3Factory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.google_cloud_storage', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\GoogleCloudStorageFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.gitlab', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\GitlabFactory::class)
            ->tag('oneup_flysystem.adapter_factory');

    $services->set('oneup_flysystem.adapter_factory.azureblob', Oneup\FlysystemBundle\DependencyInjection\Factory\Adapter\AzureBlobFactory::class)
            ->tag('oneup_flysystem.adapter_factory');
};
