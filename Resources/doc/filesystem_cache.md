# Cache your filesystems

The Flysystem library provides a few caching strategies for you to use in your adapters. This reduces the amount of API calls across requests and therefore improves job execution times and/or page loads.

In order to use a cache in your adapter you have to install the cached adapter with composer (see also http://flysystem.thephpleague.com/caching/)

```bash
composer require league/flysystem-cached-adapter
```

And add it manually in the configuration.

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

If you don't append a cache, a `Cache\Memory` [will be used](https://github.com/thephpleague/flysystem/blob/master/src/Filesystem.php#L40) implicitly. This cache is not persisted across different requests.

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
            predis:
                client: cache.redis
                key: ~
                expires: ~
```

### [Stash](https://github.com/tedious/Stash)

> Stash makes it easy to speed up your code by caching the results of expensive functions or code. Certain actions, like database queries or calls to external APIs, take a lot of time to run but tend to have the same results over short periods of time. This makes it much more efficient to store the results and call them back up later.

To learn more about available drivers, check out http://www.stashphp.com/.

```yml
services:
    cache.stash:
        class: Stash\Pool

oneup_flysystem:
    cache:
        my_cache:
            stash:
                pool: cache.stash
                key: ~ # defaults to "flysystem"
                expires: ~ # defaults to "300"
```

### Noop

This strategy prevents any kind of caching, even in the current request. Use with caution!

```yml
oneup_flysystem:
    cache:
        my_cache:
            noop: ~
```

### PSR6

```yml
services:
    cache.flysystem.psr6:
        #...
#or to use the symfony (v3.2+) cache component managed by the framework:
framework:
    cache:
        pools:
            cache.flysystem.psr6:
                adapter: cache.app

oneup_flysystem:
    cache:
        my_cache:
            psr6:
                service: cache.flysystem.psr6
                key: ~
                expires: ~
```
