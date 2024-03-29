<?php

namespace App\Modules;

use Jenssegers\Blade\Blade as SystemBlade;

class BladeModule
{
    public static function render(string $view, array $params = []): string
    {
        $systemBlade = new SystemBlade('views', 'cache');
        return $systemBlade->render($view, $params);
    }
}
