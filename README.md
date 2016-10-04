# PHP: Nelson Martell Library

[![Travis Build Status](https://img.shields.io/travis/nelson6e65/php_nml/master.svg)](https://travis-ci.org/nelson6e65/php_nml)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/nelson6e65/php_nml.svg)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nelson6e65/php_nml.svg)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/nelson6e65/php_nml.svg?b=master)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/build-status/master)
[![VersionEye](https://img.shields.io/versioneye/d/php/nelson6e65:php_nml.svg)](https://www.versioneye.com/php/nelson6e65:php_nml#dependencies)

[![GitHub release](https://img.shields.io/github/tag/nelson6e65/php_nml.svg)](https://github.com/nelson6e65/php_nml/tags)
[![Latest Version](https://img.shields.io/packagist/v/nelson6e65/php_nml.svg?label=stable)](https://packagist.org/packages/nelson6e65/php_nml)
[![Latest unstable Version](https://img.shields.io/packagist/vpre/nelson6e65/php_nml.svg?label=unstable)](https://packagist.org/packages/nelson6e65/php_nml#dev-master)
[![Waffle.io](https://img.shields.io/waffle/label/nelson6e65/php_nml/wip.svg?label=Work%20in%20progress)](http://waffle.io/nelson6e65/php_nml)
[![GitHub commits](https://img.shields.io/github/commits-since/nelson6e65/php_nml/v0.5.1.svg)](https://github.com/nelson6e65/php_nml/compare/v0.5.1...master)

[![License](https://img.shields.io/github/license/nelson6e65/php_nml.svg)](LICENSE)
[![API Documentation](http://img.shields.io/badge/documentation-API-yellow.svg)](http://nelson6e65.github.io/php_nml/api)
[![Wiki Documentation](http://img.shields.io/badge/documentation-WIKI-lightgray.svg)](https://github.com/nelson6e65/php_nml/wiki)

[![Join the chat at https://gitter.im/nelson6e65/php_nml](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nelson6e65/php_nml?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

<!-- TOC depth:4 withLinks:1 updateOnSave:0 orderedList:1 -->

## Table of content
1. [Description](#description)
2. [Requirements](#requirements)
3. [Installation](#installation)
    1. [Before install](#before-install)
    2. [Install](#install)
        1. [Via composer](#via-composer)
        2. [Via git submodule](#via-git-submodule)
        3. [Manually](#manually)
    3. [Install dependencies](#install-dependencies)
        1. [For composer installations](#for-composer-installations)
        2. [For non-composer installations](#for-non-composer-installations)
    4. [After install](#after-install)
        1. [For composer projects](#for-composer-projects)
        2. [For non-composer projects](#for-non-composer-projects)
        3. [Code Analysis](#code-analysis)
4. [Usage](#usage)

<!-- /TOC -->


## Description
Provides a set of classes for PHP applications.

**Note**: This is an unstable repository in development and should be treated as an ***alpha***.

## Requirements
* PHP 5.5 or greater
* [CakePHP Utility Classes](https://github.com/cakephp/utility) [^3.0.1](https://github.com/cakephp/utility/releases/tag/3.0.1) or grater - Only required the `Cake\Utility\Text` class (this is installed by Composer autotically).


## Installation
Use this instructions to install **NML** into your `vendor` directory as `nelson6e65/php_nml`.

> You will need [Composer](https://getcomposer.org) install and update NML and dependecies. For other alternative instructions, read [alternative instructions](https://github.com/nelson6e65/php_nml/wiki/Alternative-installation-methods).

- Move to your project root directory. Example: `cd /var/www/html/my-awesome-php-project`.
- Run `composer require nelson6e65/php_nml`. This installs `php_nml` and dependencies in your `vendor` directory (your `composer.json` will be updated).
- Configure your app to autoload classes by including the composer autoloader (`vendor/autoload.php`) in your `config.php` or `bootstrap.php` (or whatever file that performs your autoloads). In most of modern PHP frameworks this is made automatically.

Read more about Composer installs [here](https://getcomposer.org/doc/00-intro.md).

**Note**: Remember to add your `vendor` dependencies to your `.gitignore` file. (See [why](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md)).


#### Code Analysis
You can, optionally, define the `CODE_ANALYSIS` constant if you like some notices and warnings to be
throws while you are coding/debugging. This is useful to watch some recommendations about usage of
some classes, functions, methods, etc.

```php
<?php
    # app/config.php
    # . . .

    define('CODE_ANALYSIS', true);

    # . . .
?>
```


## Usage
After install NML and configure your application, you will be able to use NML classes by importing/aliasing with the [use operator](http://php.net/manual/en/language.namespaces.importing.php):

```php
<?php
//Example of Version usage:
use NelsonMartell\Version;

$nmlVersion = new Version(0, 6);

// Create Version object parsing from string
$nmlVersion = Version::parse('0.5.1');

// Explicit to string
echo $nmlVersion->toString();

// Implicit to string
echo $nmlVersion;
?>

<p>Nelson Martell Library, version <?= $nmlVersion ?></p>

```

For more details about available classes from NML, you can check the [API Documentation](http://nelson6e65.github.io/php_nml/api).
