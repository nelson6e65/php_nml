# Contributing guidelines for PHP: Nelson Martell Library

## Scripts helpers

> **Note:** This scripts should be run from root php_nml directory (where `composer.json` is).


### Development scripts

- **`composer test-code`**: Runs unit-testing tests with PHPUnit. You can pass more phpunit args with `-- <arg>`. For example: `composer test-code -- --verbose`.

- **`composer analize-code`**: Runs coding standards checks (PHP: Code Sniffer).

- **`composer autofix-code`**: Runs coding standard auto-fixes (PHP: Code Sniffer).

- **`composer check-all`**: Runs coding standard analisis (PHP: Code Sniffer) + tests (PHPUnit).

- **`composer build`**: Run this sub-scripts:
  1. **`composer build-code-coverage`**: Runs tests and build code coverage reports (XML and HTML formats) in `output/code-coverage/` directory.
    - For XML format only (`output/code-coverage/clover.xml`): **`composer build-code-coverage-clover`** or **`composer build-code-coverage-xml`** (alias).
    - For HTML format only: **`composer build-code-coverage-html`**.

- **`composer build-api`**: Generates API documentation in `output/api/` directory using [ApiGen](https://github.com/ApiGen/ApiGen).



### Deployment scripts

- `script/deploy/documentation`: Generates documentation and publish it in `gh-pages` brach.

- `script/travis-ci/deploy-documentation`: Generates documentation and publish it in `gh-pages` brach. **Note:** _This script is used by [Travis-CI](travis-ci.org) to publish documentation and should not be run in local development_.
