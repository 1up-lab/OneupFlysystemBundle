# Use the Copy.com adapter

To use the Copy.com adapter, you have to create a Copy.com API client object defined as a service.
The Flysystem adapter works with the copy-app [PHP Api](https://github.com/copy-app/php-client-library).

```yml
services:
    acme.copy_client:
        class: Barracuda\Copy\API
        arguments:
            - "consumer-key",
            - "consumer-secret"
            - "access-token",
            - "token-secret"
```

Set this service as the value of the client key in the oneup_flysystem configuration.

```yml
oneup_flysystem:
    adapters:
        my_adapter:
            copy:
                client: acme.copy_client
                prefix: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)