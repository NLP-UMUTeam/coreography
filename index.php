<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

/**
 * Application front controller.
 *
 * This file boots the framework, configures shared services
 * such as Twig and the router, resolves the current route,
 * and delegates the request to the matched controller.
 */

// Bootstrap the application and shared services.
require_once __DIR__ . '/core/bootstrap.php';




/*
|--------------------------------------------------------------------------
| Twig configuration
|--------------------------------------------------------------------------
*/

$twigConfiguration = [];

if (PRODUCTION) {
    $twigConfiguration = [
        'cache' => CACHE_DIR . 'templates',
        'auto_reload' => true,
    ];
} else {
    $twigConfiguration = [
        'cache' => false,
        'auto_reload' => true,
        'debug' => true,
    ];
}

$loader = new FilesystemLoader (__DIR__ . '/templates');
$twig = new Environment ($loader, $twigConfiguration);


// Global template variables.
$twig->addGlobal ('base_url', BASE_URL);
$twig->addGlobal ('version', PRODUCTION ? VERSION : (string) random_int(1, 10000));

// Translation helper.
if (isset ($container['i18n']) && $container['i18n']) {
    $twig->addFunction (new TwigFunction('__', function (string $method): string {
        try {
            return (string) call_user_func('I::' . $method);
        } catch (\Throwable $e) {
            return '';
        }
    }));
}


// Store Twig services in the container.
$container['loader'] = $loader;
$container['templates'] = $twig;



/*
|--------------------------------------------------------------------------
| Router configuration
|--------------------------------------------------------------------------
*/

$router = new AltoRouter();
$router->setBasePath(ltrim(BASE_URL, '/'));

$container['router'] = $router;

// Load route definitions.
require_once __DIR__ . '/routes.php';



$match = $router->match();

if ($match && is_callable ($match['target'])) {
    $controller = call_user_func_array ($match['target'], $match['params']);
} else {
    require __DIR__ . '/controllers/maintenance/NotFound404.php';
    $controller = new NotFound404 ();
}



$controller->handle ();