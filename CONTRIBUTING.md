# Contributing guidelines for PHP: Nelson Martell Library

## Global requirements
- `git` - [Git](https://git-scm.com/)
- `php` - PHP 5.6+
- `composer` - [Composer](https://getcomposer.org/)
- `yarn` - [Yarn](https://yarnpkg.com) (and `node` v8+)
- `phpdoc` - [phpDocumentor](https://www.phpdoc.org/)

### Initialization

- Clone the repository:
```bash
git clone git@github.com:nelson6e65/php_nml.git
```

- Install PHP dependencies:
```bash
composer install
```

- Install Node dependencies:
```bash
yarn
```


## Scripts helpers

> **Note:** This scripts should be run from root php_nml directory (where `composer.json` is).


### Development scripts

- **`composer test-code`**: Runs unit-testing tests with PHPUnit. You can pass more phpunit args with `-- <arg>`. For example: `composer test-code -- --verbose`.

- **`composer analize-syntax`**: Runs PHP syntax checks.

- **`composer analize-code`**: Runs coding standards checks (PHP: Code Sniffer).

- **`composer autofix-code`**: Runs coding standard auto-fixes (PHP: Code Sniffer).

- **`composer check-all`**: Runs coding standard analisis (PHP: Code Sniffer) + tests (PHPUnit).

- **`composer build-code-coverage`**: Runs tests and build code coverage reports (XML and HTML formats) in `output/code-coverage/` directory.
    - **`composer build-code-coverage-clover`**: For XML format only (`output/code-coverage/clover.xml`)
    - **`composer build-code-coverage-xml`**: Alias for `composer build-code-coverage-clover`.
    - **`composer build-code-coverage-html`**: For HTML format only.


- **`phpdoc`**: Generates the API documentation files (`*.md`) compatible with VuePress.

- **`yarn docs:dev`**: Generates VuePress documentation in development mode to check changes while writing.

- **`yarn docs:build`**: Build the VuePress documentation to be published (`phpdoc` must be run before). You can preview with the [PHP's built-in web server](http://php.net/manual/features.commandline.webserver.php):
  - **`php -S localhost:8910 -t output/docs/`**: Example to preview documentation locally in http://localhost:8910/php_nml/
