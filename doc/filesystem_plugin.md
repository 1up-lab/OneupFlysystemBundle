# Create a filesystem plugin

The only thing you have to do is to respect the Flysystem plugin API as all the plugins must implement the [PluginInterface](https://github.com/thephpleague/flysystem/blob/master/src/PluginInterface.php) provided by the flysystem library.

```php

<?php

namespace Acme\WebBundle\Services;

use League\Flysystem\Plugin\AbstractPlugin;

class ExamplePlugin extends AbstractPlugin
{
    public function getMethod()
    {
        return 'performThisMethod';
    }

    public function handle($dirname)
    {
        $filesystem = $this->filesystem;

        // Do something meaningfull.
    }
}

```

Register your plugin by creating a service:

```xml
<service id="acme_web.example_plugin" class="Acme\WebBundle\Services\ExamplePlugin" />
```

And configure your filesystem to use this plugin:

```yml
oneup_flysystem:
    filesystems:
        my_filesystem:
            adapter: #
            plugins:
                - acme_web.example_plugin
```

Afterwards, the plugin is registered on the configured filesystem and you should be able to call the `performThisMethod` method on that particular object.