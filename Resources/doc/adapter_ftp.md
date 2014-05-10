# Use the FTP adapter

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            ftp:
                host: ~
                port: ~
                username: ~
                password: ~
                root: ~
                ssl: ~
                timeout: ~
                permPrivate: ~
                permPublic: ~
                passive: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)