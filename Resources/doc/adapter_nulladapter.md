# Use the NullAdapter

According to the Flysystem documentation the NullAdapter acts like `/dev/null`, you can only write to it.
Reading from it is never possible. Can be useful for writing tests.

```yml
oneup_flysystem:
    adapters:
        my_adapter:
            nulladapter: ~
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)