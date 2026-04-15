<?php

use Pimple\Container;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;


/**
 * Application bootstrap.
 *
 * This file must be loaded by every application entry point
 * (web, CLI commands, workers, etc.).
 *
 * @author José Antonio García Díaz <joseantonio.garcia8@um.es>
 */
 
 
// Runtime configuration
set_time_limit (0);
ini_set ('memory_limit', '-1');
ini_set ('default_charset', 'UTF-8');

mb_internal_encoding ('UTF-8');
mb_regex_encoding ('UTF-8');


// Composer autoload
require_once __DIR__ . '/../vendor/autoload.php';


// Application configuration
require_once __DIR__ . '/../config.php';


// Constants
define ('PRODUCTION', (bool) $production);
define ('BASE_URL', (string) $base_url);
define ('VERSION', '2.0.0');
define ('CACHE_DIR', __DIR__ . '/../cache/');


// Error handling
if (PRODUCTION) {
    error_reporting (0);
    ini_set ('display_errors', '0');
    ini_set ('display_startup_errors', '0');
} else {
    ini_set ('display_errors', '1');
    ini_set ('display_startup_errors', '1');
    error_reporting (E_ALL);

    Debug::enable ();
}


// Dependency container
$container = new Container ();


// Require core libs
require_once __DIR__ . '/../core/functions.php';


// Database connection
// Database info is stored in config.php
if ( ! empty ($user)) {
    $database = new \CoreOGraphy\Database ($dsn, $user, $password);

    $container['connection'] = $database;
    $container['pdo'] = static function () use ($database) {
        return $database->connect();
    };
}


// Mail transport and mailer
if ( ! empty($email_server) && ! empty($email_port)) {
    
    $transport = new EsmtpTransport ($email_server, (int) $email_port);

    if ( ! empty ($email_username)) {
        $transport->setUsername($email_username);
    }

    if ( ! empty ($email_password)) {
        $transport->setPassword($email_password);
    }

    // Optional encryption: 'tls' or 'ssl'
    if (!empty($email_protocol)) {
        if ($email_protocol === 'tls') {
            $transport->setTls (true);
        
        } elseif ($email_protocol === 'ssl') {
            
            $transport = new EsmtpTransport ($email_server, (int) $email_port, true);
            
            if (!empty($email_username)) {
                $transport->setUsername ($email_username);
            }
            
            if (!empty($email_password)) {
                $transport->setPassword ($email_password);
            }
        }
    }

    $container['transport'] = $transport;
    $container['mailer'] = static function ($c) {
        return new Mailer($c['transport']);
    };
}



// Translations
$i18n = new i18n();
$i18n->setCachePath (__DIR__ . '/../cache/lang');
$i18n->setFilePath (__DIR__ . '/../lang/lang_{LANGUAGE}.json');
$i18n->setFallbackLang ('en');
$i18n->setPrefix ('I');
$i18n->setSectionSeperator ('_');
$i18n->init ();

$container['i18n'] = $i18n;


// Session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


// Custom bootstraping
require_once __DIR__ . '/../custom/bootstrap.php';