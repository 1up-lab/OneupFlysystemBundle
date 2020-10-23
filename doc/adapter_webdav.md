# Use the WebDav adapter

In order to use the WebDav adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the [sabre/dav](https://packagist.org/packages/sabre/dav) package.

```yml
services:
    acme.sabredav_client:
        class: Sabre\DAV\Client
        # ...
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            webdav:
                client: acme.sabredav_client
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)