# Use the Fallback adapter

The [litipk/flysystem-fallback-adapter](https://packagist.org/packages/litipk/flysystem-fallback-adapter) allows Flysystem to read from a fallback adapter when the files are not available through the main adapter. There is a 'forceCopyOnMain' option which copies files to the main filesystem when the are read from the fallback. This option is disabled by default.

Set this up by first defining the main and fallback adapters through flysystem. Then tie these together through the fallback adapter:

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
        upload_fallback:
            fallback:
                mainAdapter: s3_upload
                fallback: local_upload
                forceCopyOnMain: ~

```


## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
