# PHP: Nelson Martell Library

[![Travis Build Status](https://img.shields.io/travis/nelson6e65/php_nml/master.svg)](https://travis-ci.org/nelson6e65/php_nml)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/nelson6e65/php_nml.svg)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nelson6e65/php_nml.svg)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/?branch=master)
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/nelson6e65/php_nml.svg?b=master)](https://scrutinizer-ci.com/g/nelson6e65/php_nml/build-status/master)
[![VersionEye](https://img.shields.io/versioneye/d/php/nelson6e65:php_nml.svg)](https://www.versioneye.com/php/nelson6e65:php_nml#dependencies)

[![GitHub release](https://img.shields.io/github/tag/nelson6e65/php_nml.svg)](https://github.com/nelson6e65/php_nml/tags)
[![GitHub commits](https://img.shields.io/github/commits-since/nelson6e65/php_nml/v0.5.1.svg)](https://github.com/nelson6e65/php_nml/compare/v0.5.1...master)
[![Latest Version](https://img.shields.io/packagist/v/nelson6e65/php_nml.svg?label=stable)](https://packagist.org/packages/nelson6e65/php_nml)
[![Latest unstable Version](https://img.shields.io/packagist/vpre/nelson6e65/php_nml.svg?label=unstable)](https://packagist.org/packages/nelson6e65/php_nml#dev-master)


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
* [CakePHP Utility Classes](https://github.com/cakephp/utility) [^3.0.1](https://github.com/cakephp/utility/releases/tag/3.0.1) or grater - Only required the `Cake\Utility\Text` class.

## Installation
Use this instructions to install **NML** into your `vendor` directory as `nelson6e65/php_nml`.

### Before install
This instructions assumes that your current directory is your *project root directory*. Use CD command as you need (`cd path/to/your/project/root`) before to proceed.

Example: If your project is located at `/home/ltorvalds/github/awesome-php-project`, run:

    cd /home/ltorvalds/github/awesome-php-project

**Note**: You may need to install [Git](http://git-scm.com) or/and [Composer](https://getcomposer.org) in order to run some commands in the next steps.

### Install

#### Via composer
Just run this command (your `composer.json` will be updated):

    composer require nelson6e65/php_nml

This installs `php_nml` and dependencies in your `vendor` directory.

**Note**: Remember to add your `vendor` dependencies to your `.gitignore` file. (See [why](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md)).

Read more about Composer installs [here](https://getcomposer.org/doc/00-intro.md).

#### Via git submodule

    git submodule add https://github.com/nelson6e65/php_nml.git vendor/nelson6e65/php_nml
    git submodule init
    git submodule update

**Note**: You can use ssh (`git@github.com:nelson6e65/php_nml.git`) instead of https.

> Remember install dependencies manually.

Read more about Git submodules [here](http://git-scm.com/book/en/v2/Git-Tools-Submodules).

#### Manually
- Download the latest [release](https://github.com/nelson6e65/php_nml/releases).
- Unzip that download.
- Rename the resulting folder to `php_nml`.
- Then move this folder into your `vendor/nelson6e65` directory (create parent folders as needed).

> Remember install dependencies manually.


### Install dependencies
#### For composer installations
For composer installs, this is made automatically because this library includes it in composer packages requirements. So, **you don't need to take any action**.

#### For non-composer installations
Instructions are similar to this. You must follow the specific instructions for Cake Utility in https://github.com/cakephp/utility and install latest release (3.0.x).

> For consistence, you should use `vendor/cakephp/utility` directory to install it.

After install, you must to load `Cake\Utility\Text` class, including `Text.php` directly or register an autoloader for that classes.

This is an autoloader example for `Cake\Utility` namespace (if installed in your `vendor` directory as `cakephp/utility`).

```php
<?php
// File: vendor/autoload_nml_dependencies.php
// Cake\Utility location: vendor/cakephp/utility

function autoload_nml_dependencies($class)
{
    static $DS = DIRECTORY_SEPARATOR;

    if ($class[0] == '\\') {
        $class = substr($class, 1);
    }

    $classArray = explode('\\', $class);

    if ($classArray[0] == 'Cake') {
        $classArray[0] = 'cakephp';
        if ($classArray[1] == 'Utility') {
            $classArray[1] = 'utility';
        } else {
            // Is not a 'Cake\Utility' namespace.
            return;
        }
    } else {
        // Is not a 'Cake' namespace.
        return;
    }

    $path = sprintf('%s'.$DS.'%s.php', __DIR__, implode($DS, $classArray));

    if (is_file($path)) {
        require_once($path);
    } else {
        // throw new InvalidArgumentException("Error loading '$class' class. File '$path' is not present.");

    }
}

spl_autoload_register('autoload_nml_dependencies');
```


### After install
After you install NML, you should configure your app to autoload classes.

#### For composer projects
You must include the composer autoloader (`vendor/autoload.php`) in your `config.php` or `bootstrap.php` (or whatever file that you perform autoload). In most of modern PHP frameworks this is made automatically.

#### For non-composer projects
This library implements an auto-load system even for non-composer installs. You must include the [autoloader](autoload.php) provided (`vendor/nelson6e65/php_nml/autoload.php`).

Example:

```php
<?php
    # app/config.php
    # . . .

    require_once(PROJECT_ROOT.'/vendor/nelson6e65/php_nml/autoload.php');
    // Note: 'PROJECT_ROOT' is your root directory (in this case, a PHP constant).

    # . . .
```

You need to load dependent classes too. Something like:

```php
<?php
    # app/config.php
    # . . .

    require_once(PROJECT_ROOT.'/vendor/autoload_nml_dependencies.php');

    # . . .
```


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
```


## Usage
After install NML and configure your application, you will be able to use NML classes by importing/aliasing with the [use operator](http://php.net/manual/en/language.namespaces.importing.php):

```php
<?php
//Example of Version usage:
use NelsonMartell\Version;

$nmlVersion = new Version(0, 6);

echo $nmlVersion.toString();

```

For more details about available classes from NML, you can check the [API Documentation](http://nelson6e65.github.io/php_nml/api).
