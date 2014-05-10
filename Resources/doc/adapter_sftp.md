# Use the SFTP adapter

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            sftp:
                host: ~
                port: ~
                username: ~
                password: ~
                root: ~
                timeout: ~
                publicKey: ~
                permPrivate: ~
                permPublic: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)