# Use the Azure Blob Storage adapter

This adapter connects to the filesystem in the Azure Blob Storage.


```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            azureblob:
                client: 'azure_blob_storage_client' # Service ID of the MicrosoftAzure\Storage\Blob\BlobRestProxy
                container: 'container-name'
                prefix: 'optional/prefix'
```

For more details on the other parameters, take a look at the [Flysystem documentation](https://flysystem.thephpleague.com/docs/adapter/azure-blob-storage/).

## More to know

* [Create and use your filesystem](filesystem_create.md)
