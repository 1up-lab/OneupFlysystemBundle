# Use the Google Cloud Storage adapter

This adapter connects to the filesystem in the Google Cloud Storage.


```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            googlecloudstorage:
                bucket: 'my_gcs_bucket'
                prefix: ''
```

For more details on the other parameters, take a look at the [Flysystem documentation](https://flysystem.thephpleague.com/v2/docs/adapter/gcs/).

## More to know

* [Create and use your filesystem](filesystem_create.md)
