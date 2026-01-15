<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
    ])
    ->withSets([
        __DIR__ . '/vendor/filament/upgrade/src/rector.php',
    ]);
