# Use the SFTP adapter

You have to provide at least a value for the `host` key.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            sftp:
                host: ftp.domain.com
                port: ~
                username: ~
                password: ~
                root: ~
                timeout: ~
                privateKey: ~
                permPrivate: ~
                permPublic: ~
                directoryPerm: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
