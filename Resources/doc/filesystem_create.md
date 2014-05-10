# Create and use your filesystems

After successfully configured the adapters, create a filesystem and inject an adapter of your choice.

```
oneup_flysystem:
    adapter: ~
    filesystem:
        acme:
            adapter: my_adapter
            cache: ~
            alias: ~
```

This will expose a new service for you to use.

```php
$filesystem = $container->get('oneup_flysystem.acme_filesystem');
```

The naming scheme follows a simple rule: `oneup_flysystem.%s_filesystem` whereas `%s` is the name (config key) of your filesystem.
You can also access the filesystem through the [filesystem map](https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Filesystem/FilesystemMap.php).

```php
$filesystem = $container->get('oneup_flysystem.filesystem_map')->get('acme');
```

The `$filesystem` variable is of the type [`League\Filesystem`](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php).
Please refer to the [*General Usage* section](https://github.com/thephpleague/flysystem#general-usage) in the official documention for details.