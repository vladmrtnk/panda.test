<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load Config
require_once __DIR__ . '/../config/config.php';

// Routes
require_once __DIR__ . '/../config/routes.php';