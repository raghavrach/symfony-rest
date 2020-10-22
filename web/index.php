<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../src/autoload.php';

$env = getenv('APPLICATION_ENV') ?: 'dev';

if (in_array($env, ['dev', 'test'])) {
    // Load dotenv
    try {
        $dotenv = new Dotenv\Dotenv(__DIR__ . '/../config');
        $dotenv->load();
    } catch (\Exception $e) {
    }

    // Enable all debug tools
    Debug::enable();
} else {
    // Include bootstrap cache for prod
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$kernel = new ApiKernel($env, in_array($env, ['dev', 'test']));

// TODO: HttpCache
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
