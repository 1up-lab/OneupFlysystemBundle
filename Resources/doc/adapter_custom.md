# Use a custom adapter

In order to add a custom adapter, you need to provide a factory class to parse/validate your adapter's configs.

```yml
oneup_flysystem:
    adapters:
        custom_adapter:
            custom_adapter_name: #this value should match the key defined in the factory class
                factory: FullyQualified\FactoryClass\Path #or a @serviceId (note the prefix @)
                some_custom_config_1: ~
                some_custom_config_2: ~
```

For more info regarding the FactoryClass, please refer to OneupFlysystem's adapter factory classes located in DependencyInjection/Factory/Adapter

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
