# Use the Rackspace adapter

In order to use the Rackspace adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the [rackspace/php-opencloud](https://packagist.org/packages/rackspace/php-opencloud) package.

```yml
services:
    acme.rackspace_client:
        class: OpenCloud\Rackspace
        arguments:
            - "https://identity.api.rackspacecloud.com/v2.0/",
            - username: ":username"
              password: ":password"

    acme.rackspace_object_store_service:
        class: OpenCloud\ObjectStore\Service
        arguments:
            $client: "@acme.rackspace_client"
            $region: ":region"

    acme.rackspace_object_store_container:
        class: OpenCloud\ObjectStore\Resource\Container
        arguments:
            $service: "@acme.rackspace_object_store_service"
            $data: ":container_name"
```

Set the service `acme.rackspace_object_store_container` as the value of the `container` key in the `oneup_flysystem` configuration.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            rackspace:
                lazy: ~ # boolean (default "false")
                container: acme.rackspace_object_store_container
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
