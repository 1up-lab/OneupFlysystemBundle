# Cache your filesystems

The Flysystem library provides a few caching strategy for you to use in your adapters. This reduces the amount of API calls across requests and therefore improves job execution times and/or page loads.

In order to use a cache in your adapter, you have to add it manually in the configuration.

```yml
oneup_flysystem:
    cache:
        my_cache:
            noop: ~

    adapters:
        my_adapter:
            nulladapter: ~

    filesystems:
        my_filesystem:
            adapter: my_adapter
            cache: my_cache
```

This configuration creates a new filesystem based on the [`NullAdapter`](https://github.com/thephpleague/flysystem/blob/master/src/Adapter/NullAdapter.php) (write only) and injects a [`Noop`](https://github.com/thephpleague/flysystem/blob/master/src/Cache/Noop.php) cache to it. You can choose from the following implementations.

### Memory

If you don't append a cache, a `Cache\Memory` [will be used](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php#L40) implicitly.

```yml
oneup_flysystem:
    cache:
        my_cache:
            memory: ~
```

### Memcached

```yml
services:
    cache.memcached:
        class: Memcached
        calls:
            - [ addServer, [ "memcached.domain.com", 11211 ]]

oneup_flysystem:
    cache:
        my_cache:
            memcached:
                client: cache.memcached
                key: ~
                expires: ~
```

### Redis (through Predis)

The Redis cache implementation works with the Predis library. You can find more in-depth configuration options in the [corresponding documentation](https://github.com/nrk/predis#client-configuration).

```yml
services:
    cache.redis:
        class: Predis\Client

oneup_flysystem:
    cache:
        my_cache:
            memcached:
                client: cache.redis
                key: ~
                expires: ~
```

### Noop

> This strategy prevents any kind of caching, even in the current request. Use with caution!

```yml
oneup_flysystem:
    cache:
        my_cache:
            noop: ~
```
