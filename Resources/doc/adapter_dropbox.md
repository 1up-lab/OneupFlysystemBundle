# Use the Dropbox adapter

To use the Dropbox adapter, you have to create a Dropbox client object defined as a service.
The Flysystem adapter works with the official [Dropbox SDK](https://www.dropbox.com/developers/core/sdks/php).

```yml
services:
    acme.dropbox_client:
        class: Spatie\Dropbox\Client
        arguments:
            - "authorization-token"
```

Set this service as the value of the client key in the oneup_flysystem configuration.

```yml
oneup_flysystem:
    adapters:
        my_adapter:
            dropbox:
                client: acme.dropbox_client
                prefix: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
