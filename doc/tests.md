Testing the Bundle
==================

In order to run the UnitTests of this bundle, clone it first

    $> git clone git://github.com/1up-lab/OneupFlysystemBundle.git

After the cloning process, install all vendors by running the corresponding composer command.

    $> composer install --dev

## Run PHPUnit
You can run the unit tests by simply performing the follwowing command:

    $> vendor/bin/phpunit

## Run PHPStan
You can run the static php analyzer by simply performing the follwowing command:

    $> vendor/bin/phpstan analyze src/ tests/ --level=max

## Run php-cs-fixer
You can run the php code style fixer by simply performing the follwowing command:

    $> vendor/bin/php-cs-fixer fix
