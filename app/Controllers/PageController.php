<?php

namespace App\Controllers;

use App\Modules\BladeModule;

class PageController
{
    public function indexAction($request): string
    {
        return BladeModule::render('index');
    }
}