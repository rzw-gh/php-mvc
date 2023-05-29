<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

$router->add('', ['controller' => 'home', 'action' => 'index']);
//$router->add('blog/post/{id:\d+}', ['controller' => 'blog', 'action' => 'detail']);

$router->dispatch($_SERVER, $_GET, $_POST, $_FILES);
