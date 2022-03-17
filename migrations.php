<?php
// Autoloader
require_once './vendor/autoload.php';

// Load Config
require_once './config/config.php';

\App\Core\Database::getDB()->applyMigrations();