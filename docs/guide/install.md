# Getting started

## Requirements

In order to install, use and update this package you will need:

- [Composer](https://getcomposer.org)
- PHP 7.1, PHP 7.2 or PHP 7.3

::: danger Alternative install
If you don't like/want to use Composer package manager, see [**Alternative installation methods**](https://github.com/nelson6e65/php_nml/wiki/Alternative-installation-methods).
:::


## Installing

::: warning
The following instructions will assume you have `composer` [globally installed](https://getcomposer.org/doc/00-intro.md#globally).
:::

### Getting the composer package

First, require and install the package in your project:

```bash
# In your project root directory:
composer require nelson6e65/php_nml
```

::: tip
Remember to add your `vendor` directory in your `.gitignore` file ([Why?](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md)).
:::


### Configuring the autoloading

If not already done, configure your app to autoload classes with Composer by including its autoloader (`vendor/autoload.php`) in your `config.php`, `bootstrap.php` or whatever file that performs your initialization. In most of modern PHP frameworks this is made automatically.

::: tip Done!
You are able to use NML classes now!
:::


## Using

You only need to import classes under `NelsonMartell` namespace by using the [`use` operator](http://php.net/manual/en/language.namespaces.importing.php) of PHP:

```php{4}
<?php
// Rapid example of Version class usage.

use NelsonMartell\Version;

$nmlVersion = Version::parse(NML_VERSION);
?>

<!-- Implicit to string -->
<p>Nelson Martell Library, version <?= $nmlVersion ?></p>
```
