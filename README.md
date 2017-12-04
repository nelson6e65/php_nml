# PHP: Nelson Martell Library

[![Travis Build Status](https://img.shields.io/travis/nelson6e65/php_nml/master.svg)](https://travis-ci.org/nelson6e65/php_nml)
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/nelson6e65/php_nml.svg?b=master&label=scrutinizer)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/build-status/master)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/nelson6e65/php_nml.svg?label=quality)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nelson6e65/php_nml/master.svg)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![VersionEye](https://img.shields.io/versioneye/d/php/nelson6e65:php_nml.svg)](https://www.versioneye.com/php/nelson6e65:php_nml#dependencies)

[![GitHub release](https://img.shields.io/github/tag/nelson6e65/php_nml.svg)](https://github.com/nelson6e65/php_nml/tags)
[![Latest Version](https://img.shields.io/packagist/v/nelson6e65/php_nml.svg?label=stable)](https://packagist.org/packages/nelson6e65/php_nml)
[![Latest unstable Version](https://img.shields.io/packagist/vpre/nelson6e65/php_nml.svg?label=unstable)](https://packagist.org/packages/nelson6e65/php_nml#dev-master)
[![Waffle.io](https://img.shields.io/waffle/label/nelson6e65/php_nml/wip.svg?label=Work%20in%20progress)](http://waffle.io/nelson6e65/php_nml)
[![GitHub commits](https://img.shields.io/github/commits-since/nelson6e65/php_nml/v0.7.0.svg)](https://github.com/nelson6e65/php_nml/compare/v0.7.0...master)

[![License](https://img.shields.io/github/license/nelson6e65/php_nml.svg)](LICENSE)
[![API Documentation](http://img.shields.io/badge/documentation-API-yellow.svg)](http://nelson6e65.github.io/php_nml/api)
[![Wiki Documentation](http://img.shields.io/badge/documentation-WIKI-lightgray.svg)](https://github.com/nelson6e65/php_nml/wiki)

[![Join the chat at https://gitter.im/nelson6e65/php_nml](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nelson6e65/php_nml?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

<!-- TOC depthFrom:2 depthTo:6 withLinks:1 updateOnSave:0 orderedList:1 -->

## Table of content

1. [Description](#description)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Available classes](#available-classes)

<!-- /TOC -->


## Description

Provides a set of auxiliary classes to help in your PHP applications development.

**Note**: This is an unstable repository in development and should be treated as an ***alpha***.


## Requirements

In order to install, use and update this package you only will need:

* ![PHP 5.6](http://img.shields.io/badge/PHP-5.6-yellow.svg) ![PHP 7.0](http://img.shields.io/badge/PHP-7.0-yellow.svg) ![PHP 7.1](http://img.shields.io/badge/PHP-7.1-yellow.svg) ![PHP 7.2](http://img.shields.io/badge/PHP-7.2-yellow.svg)
* [Composer](https://getcomposer.org).

> The following instructions will assume you have `composer` [globally installed](https://getcomposer.org/doc/00-intro.md#globally).


## Installation

First, ***require and install the package in your project***:

```sh
# In your project root directory:
composer require nelson6e65/php_nml
```

> Remember to add your `vendor` directory in your `.gitignore` file ([Why?](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md)).

Second, if not already done, ***configure your app to autoload classes with Composer*** by including its autoloader (`vendor/autoload.php`) in your `config.php`, `bootstrap.php` or whatever file that performs your initialization. In most of modern PHP frameworks this is made automatically.

Done! You are able to use NML classes now! You only need to import classes under `NelsonMartell` namespace by using the [`use` operator](http://php.net/manual/en/language.namespaces.importing.php).

> **Note**: If you don't like/want to use Composer to install this library, read the [**Alternative installation methods**](https://github.com/nelson6e65/php_nml/wiki/Alternative-installation-methods) in the [![Wiki Documentation](http://img.shields.io/badge/documentation-WIKI-lightgray.svg)](https://github.com/nelson6e65/php_nml/wiki).


## Available classes

Check available classes in the [![API Documentation](http://img.shields.io/badge/documentation-API-yellow.svg)](http://nelson6e65.github.io/php_nml/api).

**Usage example**

```php
<?php
// Example of Version class usage.

use NelsonMartell\Version;

$nmlVersion = new Version(0, 7, '1-dev');

// Create Version object parsing from string
$nmlVersion = Version::parse(NML_VERSION);

// Explicit to string
echo $nmlVersion->toString();

// Implicit to string
echo $nmlVersion;
?>

<p>Nelson Martell Library, version <?= $nmlVersion ?></p>

```

> Note: API documentation is not updated for `0.7.0` release due to problems with the API Generation Tool (ApiGen), but will be solved soon, maybe for `v0.7.1`.


## License

[![License](https://img.shields.io/github/license/nelson6e65/php_nml.svg)](LICENSE)

Copyright (c) 2014-2017 Nelson Martell

Read the [`LICENSE` file](LICENSE) for details.
