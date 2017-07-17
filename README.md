OneupFlysystemBundle
====================

The OneupFlysystemBundle provides a [Flysystem](https://github.com/thephpleague/flysystem) integration for your Symfony projects. Flysystem is a filesystem abstraction which allows you to easily swap out a local filesystem for a remote one. Currently you can configure the following adapters to use in your Symfony project.

* [AwsS3](http://aws.amazon.com/de/sdkforphp/)
* [Dropbox](https://www.dropbox.com/developers)
* [Ftp](http://php.net/manual/en/book.ftp.php)
* [Google Cloud Storage](https://cloud.google.com/storage/)
* [Local filesystem](http://php.net/manual/en/ref.filesystem.php)
* [Rackspace](http://developer.rackspace.com/)
* [Sftp](http://phpseclib.sourceforge.net/sftp/intro.html)
* [WebDav](https://github.com/fruux/sabre-dav)
* [ZipArchive](http://php.net/manual/en/class.ziparchive.php)
* [GridFS](http://php.net/manual/en/mongo.gridfs.php)
* [Gaufrette](http://knplabs.github.io/Gaufrette/)

[![Build Status](https://travis-ci.org/1up-lab/OneupFlysystemBundle.png)](https://travis-ci.org/1up-lab/OneupFlysystemBundle)
[![Total Downloads](https://poser.pugx.org/oneup/flysystem-bundle/d/total.png)](https://packagist.org/packages/oneup/flysystem-bundle)

Documentation
-------------

The entry point of the documentation can be found in the file `Resources/docs/index.md`

[Read the documentation for master](Resources/doc/index.md)


License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/1up-lab/OneupFlysystemBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

Credit where credit is due
--------------------------

Due to the similiarities between Flysystem and Gaufrette, this bundle is *heavily* inspired by the beautifully crafted [GaufretteBundle](https://github.com/KnpLabs/KnpGaufretteBundle). Props to the devs at [KnpLab](http://knplabs.com/)!
