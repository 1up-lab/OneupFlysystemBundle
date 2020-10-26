# Use the AsyncAwsS3 adapter

In order to use the AsyncAwsS3 adapter, you first need to create a S3 client service.
This can be done with the following configuration. Read more about instantiating
the S3 client at [async-aws.com](https://async-aws.com/clients/) or use the
[AsyncAws SymfonyBundle](https://async-aws.com/integration/symfony-bundle.html).

```yml
services:
    acme.async_s3_client:
        class: AsyncAws\S3\S3Client
        arguments:
            - region: 'eu-central-1'
              accessKeyId: 'AKIAIOSFODNN7EXAMPLE'
              accessKeySecret: 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY'
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            async_aws_s3:
                client: acme.async_s3_client
                bucket: 'my_image_bucket'
                prefix: ''
```

## More to know

* [Create and use your filesystem](filesystem_create.md)
