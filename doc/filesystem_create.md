# Create and use your filesystems

After successfully configured the adapters, create a filesystem and inject an adapter of your choice.

```yml
oneup_flysystem:
    adapter: ~
    filesystems:
        acme:
            adapter: my_adapter
            alias: ~
            mount: ~
            visibility: ~
            directory_visibility: ~
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

use League\Flysystem\FilesystemOperator;

class MyService
{    
    public function __construct(FilesystemOperator $acmeFilesystem)
    {
        $this->filesystem = $acmeFilesystem;
    }
}
```

💡 Pro tip: when using **Symfony 4.2**, you can completely omit the service arguments definition in your config files,
and instead you can automatically inject your filesystems by **providing the exact same type-hint as above**, and 
replace `acme` with the name of your filesystem. Thanks to the ``ContainerBuilder::registerAliasForArgument()`` method!

## Use the Mount Manager

Details on the usage of the MountManager can be found in the [Flysystem documentation](https://flysystem.thephpleague.com/docs/advanced/mount-manager/).

## Add caching

In version 1.x of Flysystem you could provide a cache per each adapter. [The cached adapter was not ported to V2 of Flysystem](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/#miscellaneous-changes). 

If you want to use cached adapters, give a try to [lustmored/flysystem-v2-simple-cache-adapter](https://github.com/Lustmored/flysystem-v2-simple-cache-adapter).
