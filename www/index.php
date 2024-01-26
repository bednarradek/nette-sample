<?php

declare(strict_types=1);

use App\Helpers\AssetsHelper;

if (
    file_exists(__DIR__ . '/.maintenance.php') &&
    $_SERVER['REQUEST_URI'] !== '/system/migrate' //filter migrate URL
) {
    require __DIR__ . '/.maintenance.php';
    exit();
}

require __DIR__ . '/../vendor/autoload.php';

$configurator = App\Bootstrap::boot();
$container = $configurator->createContainer();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();
