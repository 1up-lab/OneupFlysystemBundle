# Use the Dropbox adapter

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            dropbox:
                client: ~
                prefix: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)