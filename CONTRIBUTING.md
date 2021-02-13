# Contributing guidelines

## Code of conduct

All contributors should adhere to the code of conduct described on the [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) file.

## Global requirements

- `git` - [Git](https://git-scm.com/)
- `php` - PHP 7.2+
- `composer` - [Composer](https://getcomposer.org/)
- `npm` - [npm](https://nodejs.org) 6 (and `node` v8+)
- `phpdoc` - [phpDocumentor 2](https://github.com/phpDocumentor/phpDocumentor/tree/2.9)

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
npm install
```

- If updating API documentation, install phpDocumentor 2 globally:

```bash
composer global require phpdocumentor/phpdocumentor:^2.9.1
# You will need PHP 7.2 in order to build the API documentation
```

## Scripts helpers

> **Note:** This scripts should be run from root php_nml directory (where `composer.json` is).

### Development scripts

#### Composer

The `composer list` exposes this project commands:

- **`composer check:all`**: Runs coding standard analysis (PHP: Code Sniffer) + tests (PHPUnit).

- **`composer refactor:lint`**: Runs [Rector](https://github.com/rectorphp/rector) on the code to check available refactors.

- **`composer refactor:write`**: Refactor the code using [Rector](https://github.com/rectorphp/rector) as helper.

- **`composer cs:php`**: Runs PHP syntax checks (PHP: Code Sniffer) and [PHPStan](https://github.com/phpstan/phpstan) analysis.

- **`composer cs:lint`**: Runs coding standards linting (PHP: Code Sniffer).

- **`composer cs:fix`**: Runs coding standards auto-fixes (PHP: Code Sniffer).

- **`composer test`**: Runs unit-testing with PHPUnit. You can pass more phpunit args with `-- <arg>`. For example: `composer test -- --verbose`.

- **`composer test:wip`**: Runs Work In Progress tests with PHPUnit (marked with `@group wip`).

- **`composer test:coverage`**: Runs PHPUnit tests and builds the code coverage report (as XML clover format) in `output/code-coverage/clover.xml`.

- **`composer test:coverage-html`**: Runs PHPUnit tests and builds the code coverage report (as HTML) in `output/code-coverage/` directory.

- **`build:api-docs`**: Generates API documentation in VuePress sources format to `docs/api/` directory using `phpDocumentor`. `phpdoc` must be installed.

#### NPM

- **`npm run cs:lint`**: Checks the code style againts [Prettier](https://github.com/prettier/prettier).

- **`npm run cs:fix`**: Fixes the code style using [Prettier](https://github.com/prettier/prettier).

- **`npm run docs:dev`**: Generates VuePress documentation in development mode to check changes while writing.

- **`npm run docs:build`**: Build the VuePress documentation to be published (`phpdoc` must be run before).

#### Other

- **`phpdoc`**: Generates the API documentation files (`*.md`) compatible with VuePress.

- - **`php -S localhost:8910 -t output/docs/`**: Example to preview documentation locally in http://localhost:8910/php_nml/ (see [PHP's built-in web server](http://php.net/manual/features.commandline.webserver.php))
