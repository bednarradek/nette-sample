<?php

namespace App\Helpers;

use RuntimeException;
use Tracy\Debugger;

class AssetsHelper
{
    private const MODULE_NAME = 'src/main.js';
    private const PATH_PREFIX = '/dist/';

    public static function loadCss():string {
        return self::PATH_PREFIX . (self::loadManifest()[self::MODULE_NAME]['css'][0] ?? "");
    }

    public static function loadJs():string {
        return self::PATH_PREFIX . (self::loadManifest()[self::MODULE_NAME]['file']?? "");
    }

    private static function loadManifest(): array {
        $manifest = __DIR__ . '/../../www/dist/.vite/manifest.json';

        if (!file_exists($manifest)) {
            throw new RuntimeException("Missing manifest.json");
        }

        $jsonData = file_get_contents($manifest);

        if ($jsonData === false) {
            throw new RuntimeException("Error load manifest.json");
        }

        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Error parse json from manifest.json");
        }
        return $data;
    }

}