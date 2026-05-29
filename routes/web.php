<?php
/**
 * Web Routes - ConsoleAsistente
 * Mantiene compatibilidad con la estructura existente
 */
$router = new AltoRouter();
$DIR = new DIR_();

// si se activa el modo edicion
$editar = false;

// con Console::log imprime las variables con la consola
$debug = true;

// ruta base
$router->setBasePath('');

// Clases disponibles
$Classes = [
    '1' => 'Landing'
];

// Cargar el nuevo HomeController
require_once 'app/Http/Controllers/HomeController.php';
require_once 'app/Http/Controllers/ApiController.php';

// ========================
// RUTAS WEB
// ========================

// Home
$router->map('GET|POST', $DIR->url("/"), 'HomeController', 'home');
$router->map('POST', $DIR->url("/pregunta"), 'HomeController', 'pregunta');
$router->map('POST', $DIR->url("/palabras"), 'HomeController', 'palabras');
$router->map('GET|POST', $DIR->url("/respuesta"), 'HomeController', 'respuesta');
$router->map('GET', $DIR->url("/404"), 'HomeController', '_404');

// Configuración LLM
$router->map('GET', $DIR->url("/config"), 'HomeController', 'config');

// ========================
// RUTAS API LLM
// ========================

// API routes (incluir solo si la ruta comienza con /api)
if (strpos($_SERVER['REQUEST_URI'], '/api') === 0) {
    require_once 'routes/api.php';
}

// match current request
$match = $router->match();