# Scripts helpers for PHP: Nelson Martell Library

> **Note:** This scripts should be run from root php_nml directory (where `composer.json` is).


## Development scripts

- `script/test-code [<filter>]`: Runs unit-testing tests with PHPUnit. Where `<filters>` is a string to filter tests to be run.

- `script/analize-code`: Runs coding standards checks.

- `script/autofix-code`: Runs coding standard auto-fixes (PHP: Code Sniffer).

- `script/build-code-coverage`: Runs tests and build code coverage reports (XML and HTML formats) in `output/code-coverage/` directory.

- `script/build-api`: Generates API documentation in `output/api/` directory using ApiGen.



## Deployment scripts

- `script/deploy/documentation`: Generates documentation and publish it in `gh-pages` brach.

- `script/travis-ci/deploy-documentation`: Generates documentation and publish it in `gh-pages` brach. **Note:** _This script is used by [Travis-CI](travis-ci.org) to publish documentation and should not be run in local development_.
