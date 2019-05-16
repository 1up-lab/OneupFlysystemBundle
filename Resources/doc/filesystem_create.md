# Create and use your filesystems

After successfully configured the adapters, create a filesystem and inject an adapter of your choice.

```yml
oneup_flysystem:
    adapter: ~
    filesystems:
        acme:
            adapter: my_adapter
            cache: ~
            alias: ~
            mount: ~
            visibility: ~
```

This will expose a new service for you to use.

```php
$filesystem = $container->get('oneup_flysystem.acme_filesystem');
```

The naming scheme follows a simple rule: `oneup_flysystem.%s_filesystem` whereas `%s` is the name (config key) of your filesystem.

The `$filesystem` variable is of the type [`\League\Flysystem\Filesystem`](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php).
Please refer to the [*General Usage* section](http://flysystem.thephpleague.com/api/#general-usage) in the official documentation for details.

## Alias your filesystem

You can alias your filesystem by providing an `alias` key.

```yml
oneup_flysystem:
    adapter: ~
    filesystems:
        acme:
            adapter: my_adapter
            alias: acme_filesystem
```
Afterwards, the filesystem service is aliased with the provided value and can be retrieved like this:

```php
$filesystem = $container->get('acme_filesystem');
```

## Inject your filesystem in your services

If you use Dependency Injection instead of the container as service locator, you can inject your filesystems in your services:

```yml
services:
    app.my_service:
        class: App\MyService
        arguments:
            - '@oneup_flysystem.acme_filesystem' # Inject the resolved service name, or the alias (see previous section)
```

Dependency Injection is considered a **good practice** since you do not need the container, and you can then refer to it in your class like this:

```php
use League\Flysystem\FilesystemInterface;

class MyService
{
    public function __construct(FilesystemInterface $acmeFilesystem)
    {
        $this->filesystem = $acmeFilesystem;
    }
}
```

💡 Pro tip: when using **Symfony 4.2**, you can completely omit the service arguments definition in your config files,
and instead you can automatically inject your filesystems by **providing the exact same type-hint as above**, and 
replace `acme` with the name of your filesystem. Thanks to the ``ContainerBuilder::registerAliasForArgument()`` method!

## Use the Mount Manager

If you provided a mount prefix, you can also access the filesystem through the [MountManager](https://github.com/thephpleague/flysystem/blob/master/src/MountManager.php).

```yml
oneup_flysystem:
    adapters:
        myadapter:
            local:
                directory: "%kernel.root_dir%/cache"

    filesystems:
        myfilesystem:
            adapter: myadapter
            mount:   prefix
```

```php
$filesystem = $container->get('oneup_flysystem.mount_manager')->getFilesystem('prefix');
```

Details on the usage of the MountManager can be found in the [Flysystem documentation](https://flysystem.thephpleague.com/docs/advanced/mount-manager/).
