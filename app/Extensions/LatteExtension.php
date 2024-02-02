<?php

namespace App\Extensions;

use App\Helpers\AssetsHelper;
use Latte\Extension;

class LatteExtension extends Extension
{
    public function getFunctions(): array
    {
        return [
            'css_path' => fn() => AssetsHelper::loadCss(),
            'js_path' => fn() => AssetsHelper::loadJs()
        ];
    }
}
