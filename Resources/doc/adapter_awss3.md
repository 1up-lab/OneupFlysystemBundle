# Use the AwsS3 adapter

In order to use the AwsS3 adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the [aws/aws-sdk-php](https://packagist.org/packages/aws/aws-sdk-php) package.

```yml
services:
    acme.s3_client:
        class: Aws\S3\S3Client
        factory_class: Aws\S3\S3Client
        factory_method: factory
        arguments:
            - ["s3-key", "s3-secret"]
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            awss3:
                client: acme.s3_client
                bucket: ~
                prefix: ~
```

For more details on the other paramters, take a look at the [Flysystem documentation](https://github.com/thephpleague/flysystem#aws-s3-setup).

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)