<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('oneup_flysystem.adapter.local', League\Flysystem\Local\LocalFilesystemAdapter::class)->abstract()
        ->args([
            'location',
            'VisibilityConverter',
            'writeFlags',
            'linkHandling',
            'MimeTypeDetector',
            'lazyRootCreation',
        ])
    ;

    $services->set('oneup_flysystem.adapter.awss3v3', League\Flysystem\AwsS3V3\AwsS3V3Adapter::class)->abstract()
        ->args([
            'S3ClientInterface',
            'bucket',
            'prefix',
            'VisibilityConverter',
            'MimeTypeDetector',
            'options',
            'streamReads',
        ]);

    $services->set('oneup_flysystem.adapter.ftp', League\Flysystem\Ftp\FtpAdapter::class)->abstract()
        ->args([
            'options',
            'FtpConnectionProvider',
            'ConnectivityChecker',
            'VisibilityConverter',
            'MimeTypeDetector',
        ]);

    $services->set('oneup_flysystem.adapter.sftp', League\Flysystem\PhpseclibV3\SftpAdapter::class)->abstract()
        ->args([
            'options',
            'root',
            'VisibilityConverter',
            'MimeTypeDetector',
        ]);

    $services->set('oneup_flysystem.adapter.memory', League\Flysystem\InMemory\InMemoryFilesystemAdapter::class)->abstract()
        ->args([
            'defaultVisibility',
        ]);

    $services->set('oneup_flysystem.adapter.async_aws_s3', League\Flysystem\AsyncAwsS3\AsyncAwsS3Adapter::class)->abstract()
        ->args([
            'Client',
            'Bucket',
            'Prefix',
            'VisibilityConverter',
        ]);

    $services->set('oneup_flysystem.adapter.googlecloudstorage', League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter::class)->abstract()
        ->args([
            'Client',
            'Bucket',
            'Prefix',
            'VisibilityHandler',
            'defaultVisibility',
            'mimeTypeDetector',
        ]);

    $services->set('oneup_flysystem.adapter.gitlab', RoyVoetman\FlysystemGitlab\GitlabAdapter::class)->abstract()
        ->args([
            'Client',
            'Prefix',
        ]);

    $services->set('oneup_flysystem.adapter.azureblob', League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter::class)->abstract()
        ->args([
            'Client',
            'Container',
            'Prefix',
        ]);
};
