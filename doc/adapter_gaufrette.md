# Use the Gaufrette adapter

In order to use the Gaufrette adapter, you first need to create
a gaufrette adapteter defined as a service. This Flysystem adapter
works with the [knplabs/knp-gaufrette-bundle](https://packagist.org/packages/knplabs/knp-gaufrette-bundle) package,
so you can use the services they provide for your adapter, e.g:

```
gaufrette.local_adapter
```

or you can define services manually if using Gaufrette without that bundle:

```yml
services:
    acme.gaufrette_adapter:
        class: Gaufrette\Adapter\Local
        # ...
```

Set this service as the value of the `adapter` key in the `oneup_flysystem` configuration.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            gaufrette:
                adapter: gaufrette.local_adapter
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
