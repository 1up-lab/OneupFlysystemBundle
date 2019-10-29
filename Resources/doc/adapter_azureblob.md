# Use the Azure Blob Storage adapter

In order to use the Azure Blob Storage adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the [microsoft/azure-storage-blob](https://packagist.org/packages/microsoft/azure-storage-blob) package version 0.1.4 and above.

```yml
services:
    acme.azure_blob_client:
        factory: "MicrosoftAzure\\Storage\\Blob\\BlobRestProxy::createBlobService"
        arguments:
          - '%env(AZURE_BLOB_STORAGE_CONNECTION_STRING)%'
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            azureblob:
                client: acme.azure_blob_client
                container: 'my_container'
                prefix: ~
```
