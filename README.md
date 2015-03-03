[![API Docs](http://apigenerator.org/badge.png)](http://nelson6e65.github.io/php_nml/api)
# PHP: Nelson Martell Library

## Description
Provides a set of classes for PHP applications.

**Note**: This is an unstable repository in development and should be treated as an ***alpha***.

## Requirements
* PHP 5.5 or greater

## Installation

### As Git submodule
In your app directory, type:

    git submodule add https://github.com/nelson6e65/php_nml.git Vendor/NML
	git submodule init
	git submodule update

This installs NML into your Vendor directory.

### Manually
* Download any NML [Release](https://github.com/nelson6e65/php_nml/releases) or [Master development](https://github.com/nelson6e65/php_nml/archive/master.zip).
* Unzip that download.
* Rename the resulting folder to NML
* Then copy/move this folder into your vendor directory

## Usage
For availability of classes, on non-composer install, first you should import 'autoload.php' in order to autoload classes.

```php
require_once('path/to/your/app/Vendor/NML/autoload.php');
```

Or you can include file by file.


Then, you can use classes from this library, using namespace:

```php
//Example of use of Version class:
use NelsonMartell\Version;

$nmlVersion = new Version(0, 3);

echo $nmlVersion.ToString();

```

For more details, you can check the [API reference](http://nelson6e65.github.io/php_nml/api).

### Code Analysis
You can, optionally, define the '' constant if you like some notices and warnings to be
throws while you are coding/debugging. This is useful to watch some recommendations about usage of
some clases, functions, methods, etc.

```php
<?php
	define('CODE_ANALYSIS', true);

	//...
```
