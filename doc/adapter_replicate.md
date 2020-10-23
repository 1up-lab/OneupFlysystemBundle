# Use the Replicate adapter

The [league/flysystem-replicate-adapter](https://packagist.org/packages/league/flysystem-replicate-adapter) acilitates smooth transitions between adapters, allowing an application to stay functional and migrate its files from one adapter to another. The adapter takes two other adapters, a source and a replica. Every change is delegated to both adapters, while all the read operations are passed onto the source only.

Set this up by first defining the source and replica adapters through flysystem. Then tie these together through the replicate adapter:

```yml

oneup_flysystem:
    adapters:
        s3_upload:
            awss3v3:
                client: acme.s3_client
                bucket: ~
                prefix: ~
        local_upload:
            local:
                directory: "%kernel.root_dir%/../uploads"
        upload_replicate:
            replicate:
                sourceAdapter: s3_upload
                replicaAdapter: local_upload

```


## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
