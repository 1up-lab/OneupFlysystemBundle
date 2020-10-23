# Use the ZipArchive adapter

This adapter works with the standard PHP ZipArchive implementation which is documented in [the manual](http://www.php.net/manual/de/class.ziparchive.php).
You have to provide at least a value for the `location` key.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            zip:
                location: "%kernel.root_dir%/Resources/fs.zip"
                archive: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)