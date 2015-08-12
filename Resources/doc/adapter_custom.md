# Use the Custom adapter

In order to use a custom adapter, you first need to create
a service implementing the `League\Flysystem\AdapterInterface`.

Set this service as the value of the `service` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            custom:
                service: my_flysystem_service
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
