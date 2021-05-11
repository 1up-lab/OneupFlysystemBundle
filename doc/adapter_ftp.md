# Use the FTP adapter

This adapter works with the standard PHP FTP implementation which is documented in [the manual](http://www.php.net/manual/en/book.ftp.php).
You have to provide at least a value for the `host` key.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            ftp:
                options:
                    host: 'ftp.hostname.com' # required
                    root: '/upload' # required
                    username: 'username' # required
                    password: 'password' # required
```

For more details on the other parameters, take a look at the [Flysystem documentation](https://flysystem.thephpleague.com/v2/docs/adapter/ftp/).

## More to know
* [Create and use your filesystem](filesystem_create.md)
