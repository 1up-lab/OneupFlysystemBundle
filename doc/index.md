# Getting started

The OneupFlysystemBundle was developed and tested for Symfony version 4.4+.

## Installation
Perform the following steps to install and use the basic functionality of the OneupFlysystemBundle:

* Download OneupFlysystemBundle using Composer
* Enable the bundle
* Configure your filesystems

### Step 1: Download the bundle

Download the bundle via composer:

```
$> php composer.phar require oneup/flysystem-bundle
```

Composer will now fetch and install this bundle in the vendor directory `vendor/oneup`

**Note**: There are some additional dependencies you will need to install for some features:

* The AwsS3v3 adapter requires `"league/flysystem-aws-s3-v3"`
* The FTP adapter requires `"league/flysystem-ftp"`
* The SFTP adapter requires `"league/flysystem-sftp"`
* The InMemory adapter requires `"league/flysystem-memory"`
* The AsyncAwsS3 adapter requires `"async-aws/flysystem-s3"`
* The Gitlab adapter requires `"royvoetman/flysystem-gitlab-storage"`

### Step 2: Enable the bundle
Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Oneup\FlysystemBundle\OneupFlysystemBundle(),
    );
}
```

### Step3: Configure your filesystems
In order to create a filesystem, you first need to create an adapter. An easy example is to define a local adapter
and afterwards create a filesystem based on it.

```yaml
# app/config/config.yml
oneup_flysystem:
    adapters:
        my_adapter:
            local:
                directory: "%kernel.root_dir%/cache"

    filesystems:
        my_filesystem:
            adapter: my_adapter

            # optional - defines the default visibility of the filesystem: `public` or `private`(default)
            visibility: private
```

There are a bunch of adapters for you to use:

* [AsyncAwsS3](adapter_async_aws_s3.md)
* [AwsS3](adapter_awss3.md)
* [Ftp](adapter_ftp.md)
* [Local filesystem](adapter_local.md)
* [InMemoryAdapter](adapter_in_memory.md)
* [Sftp](adapter_sftp.md)
* [Gitlab](adapter_gitlab.md)
* [Custom](adapter_custom.md)

### Step 4: Next steps

After installing and setting up the basic functionality of this bundle you can move on and integrate some more advanced features.

* [Create and use your filesystems](filesystem_create.md)
* [Running the tests](tests.md)
* [Use your own flysystem adapters](adapter_custom.md)
* [Config based on PHP files](filesystem_php_config.md)
