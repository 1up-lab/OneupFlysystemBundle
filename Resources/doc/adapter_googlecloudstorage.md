# Use the Google Cloud Storage adapter

To use the Google Cloud Storage adapter, you have to create a Google Storage client object defined as a service.
The [Flysystem adapter](https://github.com/Superbalist/flysystem-google-cloud-storage) works with the official [Google Cloud Client Library](https://googlecloudplatform.github.io/google-cloud-php/#/).

More documentation on client configuration options and use cases can be [found here](https://github.com/Superbalist/flysystem-google-cloud-storage).

```yml
services:
    acme.google_storage_client:
        class: Google\Cloud\Storage\StorageClient
        arguments:
            - projectId: "your-project-id"
              keyFilePath: '/path/to/service-account.json' # optional

    acme.google_storage_bucket:
        class: Google\Cloud\Storage\Bucket
        factory: 'acme.google_storage_client:bucket'
        arguments:
            name: 'your-bucket-name'
```

Set these services as the client and bucket values in the oneup_flysystem configuration.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            googlecloudstorage:
                client: acme.google_storage_client
                bucket: acme.google_storage_bucket
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
