<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('oneup_flysystem.adapter.local', League\Flysystem\Local\LocalFilesystemAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.awss3v3', League\Flysystem\AwsS3V3\AwsS3V3Adapter::class)->public();
    $services->set('oneup_flysystem.adapter.ftp', League\Flysystem\Ftp\FtpAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.sftp', League\Flysystem\PhpseclibV3\SftpAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.memory', League\Flysystem\InMemory\InMemoryFilesystemAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.async_aws_s3', League\Flysystem\AsyncAwsS3\AsyncAwsS3Adapter::class)->public();
    $services->set('oneup_flysystem.adapter.googlecloudstorage', League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.gitlab', RoyVoetman\FlysystemGitlab\GitlabAdapter::class)->public();
    $services->set('oneup_flysystem.adapter.azureblob', League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter::class)->public();
};
