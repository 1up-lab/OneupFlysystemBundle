# Use the AwsS3 adapter

There are two AwsS3 adapters that you can use with this bundle. Below is the configuration for AwsS3v3 and AwsS3v2 adapters.

## AwsS3v3

In order to use the AwsS3v3 adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the [aws/aws-sdk-php](https://packagist.org/packages/aws/aws-sdk-php) package version 3 and above. 
This version requires you to use the "v4" of the signature.

```yml
services:
    acme.s3_client:
        class: Aws\S3\S3Client
        arguments:
            -
                version: '2006-03-01' # or 'latest'
                region: "region-id" # 'eu-central-1' for example
                credentials:
                    key: "s3-key"
                    secret: "s3-secret"
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            awss3v3:
                client: acme.s3_client
                bucket: ~
                prefix: ~
```

For more details on the other parameters, take a look at the [Flysystem documentation](https://flysystem.thephpleague.com/v2/docs/adapter/aws-s3-v3/).

## More to know
* [Create and use your filesystem](filesystem_create.md)
