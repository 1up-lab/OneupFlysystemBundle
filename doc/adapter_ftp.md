# Use the FTP adapter

This adapter works with the standard PHP FTP implementation which is documented in [the manual](http://www.php.net/manual/en/book.ftp.php).
You have to provide at least a value for the `host` key.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            ftp:
                host: ftp.domain.com
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
