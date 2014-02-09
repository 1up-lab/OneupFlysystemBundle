# Use the AwsS3 adapter

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            awss3:
                client: ~
                bucket: ~
                prefix: ~
```