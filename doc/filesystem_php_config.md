# Config based on PHP files

If you're using Symfony 5 and want to configure this bundle with a PHP file instead of a YAML,
you can set up the `config/packages/oneup_flysystem.php` file like this:

```php

<?php declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void
{
    $configurator->extension('oneup_flysystem', [
        'adapters' => [
            'my_adapter' => [
                'local' => [
                    'directory' => '%kernel.root_dir%/cache'
                ]
            ]
        ],
        'filesystems' => [
            'my_filesystem' => [
                'adapter' => 'my_adapter',
                'visibility' => 'private'
            ]
        ]
    ]);
};
```
