<?php

namespace App\Controllers;

use App\Modules\Blade;
use Symfony\Component\Routing\RouteCollection;

class PageController
{
    public function indexAction($request): string
    {
        return Blade::render('index');
    }
}