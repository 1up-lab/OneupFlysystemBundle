Testing the Bundle
==================

In order to run the UnitTests of this bundle, clone it first

```sh
git clone git://github.com/1up-lab/OneupFlysystemBundle.git
```

After the cloning process, install all vendors by running the corresponding composer command.

```sh
composer install --dev
```

## Run PHPUnit
You can run the unit tests by simply performing the following command:

```sh
git vendor/bin/phpunit
```

## Run PHPStan
You can run the static php analyzer by simply performing the following command:

```sh
vendor/bin/phpstan analyze src/ tests/ --level=max
```

## Run php-cs-fixer
You can run the php code style fixer by simply performing the following command:

```sh
vendor/bin/php-cs-fixer fix
```
