<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function dd($var, $exit = true)
{
    dump($var);
    if ($exit)
        die();
}

// Autoloader
require_once './vendor/autoload.php';

// Load Config
require_once './config/config.php';

// Database
require_once './app/Core/Database.php';

// Routes
require_once './routes/web.php';
require_once './app/Core/Router.php';
