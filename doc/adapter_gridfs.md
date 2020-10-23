# Use the GridFS adapter

In order to use the GridFS adapter, you first need to create
a client object defined as a service. This Flysystem adapter
works with the MongoDB PHP extension.

```yml
 parameters:
     acme_test.mongo.server:  "mongodb://localhost:27017"
     acme_test.mongo.options:
         connect: true
     acme_test.mongodb.name:  "test_database"
     acme_test.gridfs.prefix: "fs" # Default

 services:
     acme_test.mongo:
         class:     Mongo
         arguments: ["%acme_test.mongo.server%", "%acme_test.mongo.options%"]
     acme_test.mongodb:
         class:     MongoDB
         arguments: ["@acme_test.mongo", "%acme_test.mongodb.name%"]
     acme_test.gridfs_client:
         class:     MongoGridFS
         arguments: ["@acme_test.mongodb", "%acme_test.gridfs.prefix%"]
```

Set this service as the value of the `client` key in the `oneup_flysystem` configuration.

```yml
oneup_flysystem:
    adapters:
        acme.flysystem_adapter:
            gridfs:
                client: acme_test.gridfs_client
```

## More to know
* [Create and use your filesystem](filesystem_create.md)
* [Add a cache](filesystem_cache.md)
