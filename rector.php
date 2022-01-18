<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Core\ValueObject\PhpVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    $parameters->set(Option::AUTO_IMPORT_NAMES, true);

    // $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);

    $containerConfigurator->import(SetList::PHP_72);
    // $containerConfigurator->import(SetList::PHP_73);
    // $containerConfigurator->import(SetList::PHP_74);

    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_80);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_90);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_91);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_EXCEPTION);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_SPECIFIC_METHOD);
    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);

    // SetList::CODING_STYLE,
    // SetList::PRIVATIZATION,

    // SetList::CODE_QUALITY,
    // SetList::DEAD_CODE,

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();
};
