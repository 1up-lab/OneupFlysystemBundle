# Use the ZipArchive adapter

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            zip:
                location: ~
                archive: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)