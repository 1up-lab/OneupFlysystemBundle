# Use the SFTP adapter

You have to provide at least a value for the `host` key.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            sftp:
                options:
                    host: 'ftp.domain.com'
                    username: 'foo'
                    root: '/upload'
```

For more details on the other parameters, take a look at the [Flysystem documentation](https://flysystem.thephpleague.com/docs/adapter/sftp-v3/).

## More to know
* [Create and use your filesystem](filesystem_create.md)
