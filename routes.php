<?php

/**
 * Application routes.
 *
 * This file registers the HTTP routes handled by the application.
 *
 * Conventions:
 * - Controller routes return an instantiated controller.
 * - Simple utility routes may handle the response directly.
 * - Controllers are loaded from the controllers/ directory.
 */

/**
 * Load and instantiate a controller class from the controllers directory.
 *
 * Example:
 *   controller('login/Index.php', 'Index')
 *
 * @param string $file  Relative path inside controllers/
 * @param string $class Class name to instantiate
 *
 * @return object
 */
function controller (string $file, string $class): object {
    require __DIR__ . '/controllers/' . $file;
    return new $class();
}

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

/**
 * Home page.
 *
 * The root path currently redirects users to the maintenance / not found page.
 */
$router->map ('GET', '/', function () {
    return controller ('maintenance/NotFound404.php', 'NotFound404');
});