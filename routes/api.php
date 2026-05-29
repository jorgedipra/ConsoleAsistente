<?php
/**
 * API Routes - Endpoints REST para el ConsoleAsistente
 * Sistema de procesamiento de lenguaje natural y LLM
 */
$routerApi = new AltoRouter();

/**
 * POST /api/nlp/process
 * Procesa lenguaje natural y devuelve respuesta
 */
$routerApi->map('POST', '/api/nlp/process', function() {
    require_once 'api/Conexion/conexion.php';
    require_once 'api/Conexion/PtcQueryBuilder.php';
    require_once 'app/Http/Controllers/BaseController.php';

    $controller = new HomeController();
    $controller->pregunta();
});

/**
 * POST /api/words/check
 * Verifica si una palabra existe en el vocabulario
 */
$routerApi->map('POST', '/api/words/check', function() {
    require_once 'api/Conexion/conexion.php';
    require_once 'api/Conexion/PtcQueryBuilder.php';
    require_once 'app/Http/Controllers/BaseController.php';

    $controller = new HomeController();
    $controller->palabras();
});

/**
 * POST /api/responses/add
 * Agrega una nueva respuesta a una pregunta
 */
$routerApi->map('POST', '/api/responses/add', function() {
    require_once 'api/Conexion/conexion.php';
    require_once 'api/Conexion/PtcQueryBuilder.php';
    require_once 'app/Http/Controllers/BaseController.php';

    $controller = new HomeController();
    $controller->respuesta();
});

/**
 * GET /api/commands
 * Lista todos los comandos disponibles
 */
$routerApi->map('GET', '/api/commands', function() {
    header('Content-Type: application/json; charset=utf-8');

    // Comandos predefinidos del asistente
    $comandos = [
        ['nombre' => 'HOLA', 'funcion' => 'saludar', 'descripcion' => 'Saluda al asistente'],
        ['nombre' => 'ESCUCHAR', 'funcion' => 'escuchar', 'descripcion' => 'Activa el micrófono'],
        ['nombre' => 'ADIOS', 'funcion' => 'despedirse', 'descripcion' => 'Se despide del asistente'],
        ['nombre' => 'VER COMANDOS', 'funcion' => 'vercomandos', 'descripcion' => 'Muestra lista de comandos'],
        ['nombre' => '-APRENDER', 'funcion' => 'aprender', 'descripcion' => 'Activa modo aprendizaje'],
        ['nombre' => '-SALIR', 'funcion' => 'salir', 'descripcion' => 'Termina modo aprendizaje'],
        ['nombre' => '-TERMINAR', 'funcion' => 'terminar', 'descripcion' => 'Termina sesión']
    ];

    echo json_encode([
        'status' => 'success',
        'comandos' => $comandos,
        'total' => count($comandos)
    ]);
});

/**
 * GET /api/config
 * Devuelve configuración del asistente (nombre, creadores)
 */
$routerApi->map('GET', '/api/config', function() {
    require_once 'api/Conexion/conexion.php';
    require_once 'api/Conexion/PtcQueryBuilder.php';
    require_once 'app/Http/Controllers/BaseController.php';

    $controller = new HomeController();
    $controller->config();
});

/**
 * GET /api/health
 * Verificación de salud de la API
 */
$routerApi->map('GET', '/api/health', function() {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'ok',
        'service' => 'ConsoleAsistente API',
        'version' => '1.0.0',
        'timestamp' => date('c')
    ]);
});

// ========================
// RUTAS LLM
// ========================

/**
 * POST /api/llm/chat
 * Envía mensaje y obtiene respuesta del LLM
 */
$routerApi->map('POST', '/api/llm/chat', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->chat();
});

/**
 * GET /api/llm/history
 * Obtiene historial de conversación
 */
$routerApi->map('GET', '/api/llm/history', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->history();
});

/**
 * POST /api/llm/config
 * Guarda configuración del LLM
 */
$routerApi->map('POST', '/api/llm/config', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->saveConfig();
});

/**
 * GET /api/llm/config
 * Obtiene configuración actual del LLM
 */
$routerApi->map('GET', '/api/llm/config', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->getConfig();
});

/**
 * GET /api/llm/providers
 * Lista providers disponibles
 */
$routerApi->map('GET', '/api/llm/providers', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->providers();
});

/**
 * GET /api/llm/health
 * Verifica estado del LLM
 */
$routerApi->map('GET', '/api/llm/health', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->health();
});

/**
 * DELETE /api/llm/history
 * Limpia historial de conversación
 */
$routerApi->map('DELETE', '/api/llm/history', function() {
    require_once 'app/Http/Controllers/ApiController.php';
    $controller = new ApiController();
    $controller->clearHistory();
});

// Match API routes
$apiMatch = $routerApi->match();

// Si hay match, ejecutar el callback
if ($apiMatch && is_callable($apiMatch['target'])) {
    call_user_func_array($apiMatch['target'], $apiMatch['params']);
} else {
    // 404 para API
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Endpoint no encontrado'
    ]);
}