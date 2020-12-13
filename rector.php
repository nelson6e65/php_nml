<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::PHP_71,
        SetList::PHPUNIT_75,
        SetList::PHPUNIT_80,
        SetList::PHPUNIT_90,
        SetList::PHPUNIT_91,
    ]);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();
};