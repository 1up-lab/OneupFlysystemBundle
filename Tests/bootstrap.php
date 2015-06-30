<?php

$loader = @include __DIR__.'/../vendor/autoload.php';
if (!$loader) {
    die(<<<'EOT'
You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install
EOT
    );
}

passthru(sprintf('rm -rf %s/App/cache', __DIR__));
spl_autoload_register(function ($class) {
    if (0 === strpos($class, 'Oneup\\FlysystemBundle\\')) {
        $path = __DIR__.'/../'.implode('/', array_slice(explode('\\', $class), 2)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;

        return true;
    }
});
