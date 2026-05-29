<?php
/**
 * Router para servidor PHP incorporado
 */
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Solo manejar peticiones API
if (strpos($uri, '/api/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    require __DIR__ . '/index.php';
    return true;
}

// Dejar que PHP sirva página principal y archivos estáticos
return false;
