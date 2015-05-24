[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nelson6e65/php_nml/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/nelson6e65/php_nml/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/nelson6e65/php_nml/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/build-status/master)

[![API Docs](http://apigenerator.org/badge.png)](http://nelson6e65.github.io/php_nml/api)

# [PHP: Nelson Martell Library](http://nelson6e65.github.io/php_nml) 

## Description
Provides a set of classes for PHP applications.

**Note**: This is an unstable repository in development and should be treated as an ***alpha***.

## Requirements
* PHP 5.5 or greater
* [CakePHP Utility Classes](https://github.com/cakephp/utility) [3.0.5](https://github.com/cakephp/utility/releases/tag/3.0.5) or grater - Only needed `Cake\Utility\Text` class, that should be loaded. There is a copy of that class into `vendor` directory to be auto-used if CakePHP Utility Classes is not available.

## Installation

### As Git submodule
In your ***vendor*** directory, type:

    git submodule add https://github.com/nelson6e65/php_nml.git
	git submodule init
	git submodule update

Or you can also clone using ssh auth:

    git submodule add git@github.com:nelson6e65/php_nml.git
    git submodule init
	git submodule update

This installs NML into your Vendor directory as `php_nml`.

### Manually
* Download NML from  [releases](https://github.com/nelson6e65/php_nml/releases),  master-[tar.gz](https://github.com/nelson6e65/php_nml/tarball/master) or master-[zip](https://github.com/nelson6e65/php_nml/zipball/master).
* Unzip that download.
* Rename the resulting folder to `php_nml`.
* Then copy/move this folder into your vendor directory

# Usage
This library implements an auto-load system even for non-composer installs.

First you should import `autoload.php` file from `php_nml` root directory into your app configuration file:

```php
<?php
    //app/config.php
    //Other configs of your application...
    require_once('path/to/your/app/Vendor/php_nml/autoload.php');
    //...
```

Then, the library classes will be available to use:

```php
<?php
//Example of use of Version class:
use NelsonMartell\Version;

$nmlVersion = new Version(0, 3);

echo $nmlVersion.ToString();

```

**Note:** If you dont' use [CakePHP Utility Classes](https://github.com/cakephp/utility), there is a minimal copy of needed class in `php_nml/vendor/Cake/Utility` directory. This `autoload.php` includes `php_nml/vendor/autoload.php` file to autoloads psr-4 classes from that `vendor`.

For more details about available classes from NML, you can check the [API Documentation](http://nelson6e65.github.io/php_nml/api).

#### Code Analysis
You can, optionally, define the `CODE_ANALYSIS` constant if you like some notices and warnings to be
throws while you are coding/debugging. This is useful to watch some recommendations about usage of
some clases, functions, methods, etc.

```php
<?php
    //Other configs of your application
    //..
	define('CODE_ANALYSIS', true);
	//...
```
