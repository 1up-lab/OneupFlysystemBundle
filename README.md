OneupFlysystemBundle
====================

[![Build Status](https://github.com/1up-lab/OneupFlysystemBundle/workflows/CI/badge.svg)](https://github.com/1up-lab/OneupFlysystemBundle/actions)
[![Total Downloads](https://poser.pugx.org/oneup/flysystem-bundle/d/total.png)](https://packagist.org/packages/oneup/flysystem-bundle)

**Now 4.x available with [Flysystem 2](https://flysystem.thephpleague.com/v2/docs/what-is-new/) support!**

The OneupFlysystemBundle provides a [Flysystem](https://github.com/thephpleague/flysystem) integration for your Symfony projects. Flysystem is a filesystem abstraction which allows you to easily swap out a local filesystem for a remote one. Currently you can configure the following adapters to use in your Symfony project.

* [AsyncAwsS3](https://async-aws.com/)
* [AwsS3](http://aws.amazon.com/de/sdkforphp/)
* [Ftp](http://php.net/manual/en/book.ftp.php)
* [Local filesystem](http://php.net/manual/en/ref.filesystem.php)
* [Sftp](http://phpseclib.sourceforge.net/sftp/intro.html)

Documentation
-------------

The entry point of the documentation can be found in the file `doc/index.md`

[Read the documentation for master](doc/index.md)


Flysystem 1.x
-------------
If you're looking for Flysystem 1.x support, check out the [3.x-branch](https://github.com/1up-lab/OneupFlysystemBundle/tree/release/3.x) of this bundle.


License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/1up-lab/OneupFlysystemBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [symfony/website-skeleton](https://symfony.com/doc/current/setup.html#creating-symfony-applications)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.
