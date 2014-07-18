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
            mount: ~
```

This will expose a new service for you to use.

```php
$filesystem = $container->get('oneup_flysystem.acme_filesystem');
```

The naming scheme follows a simple rule: `oneup_flysystem.%s_filesystem` whereas `%s` is the name (config key) of your filesystem.
If you provided a mount prefix, you can also access the filesystem through the [MountManager](https://github.com/thephpleague/flysystem/blob/master/src/MountManager.php).

```php
$filesystem = $container->get('oneup_flysystem.mount_manager')->getFilesystem('prefix');
```

Details on the usage of the MountManager can be found in the [Flysystem documentation](https://github.com/thephpleague/flysystem#mount-manager).

The `$filesystem` variable is of the type [`League\Filesystem`](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php).
Please refer to the [*General Usage* section](https://github.com/thephpleague/flysystem#general-usage) in the official documention for details.