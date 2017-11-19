# Use the local adapter

To use the local adapter which stores files on the same server the Symfony2 instance runs, you have
to provide a directory.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            local:
                directory: "%kernel.root_dir%/../uploads"
                lazy: ~ # boolean (default "false")
                writeFlags: ~
                linkHandling: ~
                permissions: ~
```

For more details on the `lazy` parameter, take a look at the [Symfony documentation](http://symfony.com/doc/current/components/dependency_injection/lazy_services.html).
For the other parameters, take a look at the [Flysystem documentation](http://flysystem.thephpleague.com/adapter/local/).

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)