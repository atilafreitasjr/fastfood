<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if the application is in maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Create the application kernel
$kernel = $app->make(Kernel::class);

// Handle the incoming request
$response = $kernel->handle(
    $request = Request::capture()
);

// Send the response
$response->send();

// Terminate the application
$kernel->terminate($request, $response);