<?php
/**
 * LlmService - Servicio principal para interactuar con LLMs
 * Soporta Ollama, Claude (Anthropic) y OpenAI
 */
require_once __DIR__ . '/LlmProviders/LlmProviderInterface.php';
require_once __DIR__ . '/LlmProviders/OllamaService.php';
require_once __DIR__ . '/LlmProviders/ClaudeService.php';
require_once __DIR__ . '/LlmProviders/OpenAiService.php';
require_once __DIR__ . '/LlmProviders/CustomService.php';

class LlmService
{
    private $provider;
    private $model;
    private $config;

    public function __construct()
    {
        $this->config = $this->cargarConfiguracion();
        $this->provider = $this->config['provider'] ?? 'ollama';
        $this->model = $this->config['model'] ?? 'llama3';
    }

    /**
     * Carga configuración desde la base de datos
     */
    private function cargarConfiguracion()
    {
        // Valores por defecto
        $defaults = [
            'provider' => 'ollama',
            'model' => 'llama3',
            'endpoint' => 'http://localhost:11434',
            'api_key' => '',
            'config_json' => '{"temperature": 0.7, "max_tokens": 500}'
        ];

        // Intentar conectar a la base de datos
        if (!isset($GLOBALS['Conexion_ID']) || $GLOBALS['Conexion_ID'] === null || $GLOBALS['Conexion_ID'] === 0) {
            // Intentar crear conexión
            if (class_exists('Conex')) {
                try {
                    $conex = new Conex();
                    $GLOBALS['Conexion_ID'] = $conex->conectar();
                } catch (Exception $e) {
                    return $defaults;
                }
            } else {
                return $defaults;
            }
        }

        $Conexion_ID = $GLOBALS['Conexion_ID'];

        // Verificar si la conexión es válida
        if (!$Conexion_ID || $Conexion_ID === 0) {
            return $defaults;
        }

        $sql = "SELECT * FROM config_llm WHERE activo = 1 LIMIT 1";
        $result = @mysqli_query($Conexion_ID, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }

        return $defaults;
    }

    /**
     * Obtiene la configuración actual
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Obtiene los providers disponibles
     */
    public function getProviders()
    {
        return [
            'ollama' => [
                'name' => 'Ollama (Local)',
                'description' => 'Ejecuta modelos localmente sin costo',
                'models' => ['llama3', 'llama3.2', 'mistral', 'codellama', 'phi3', 'qwen2.5']
            ],
            'anthropic' => [
                'name' => 'Claude (Anthropic)',
                'description' => 'API de Anthropic - Modelos avanzados',
                'models' => ['claude-3-haiku-20240307', 'claude-3-sonnet-20240229', 'claude-3-opus-20240229', 'claude-3.5-haiku-20241022', 'claude-3.5-sonnet-20241022']
            ],
            'openai' => [
                'name' => 'OpenAI (GPT)',
                'description' => 'API de OpenAI - GPT-4 y GPT-3.5',
                'models' => ['gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo']
            ],
            'custom' => [
                'name' => 'URL Personalizada',
                'description' => 'Conectar a cualquier API compatible',
                'models' => ['custom']
            ]
        ];
    }

    /**
     * Envía un mensaje y obtiene respuesta del LLM
     * @param string $mensaje Mensaje del usuario
     * @param array $historial Historial de conversación
     * @return string Respuesta del LLM
     */
    public function ask($mensaje, $historial = [])
    {
        $service = $this->crearService();

        if (!$service) {
            return "Error: Provider no configurado";
        }

        return $service->chat($mensaje, $historial);
    }

    /**
     * Crea la instancia del servicio según el provider
     */
    private function crearService()
    {
        $endpoint = $this->config['endpoint'] ?? 'http://localhost:11434';
        $apiKey = $this->config['api_key'] ?? '';
        $extraConfig = json_decode($this->config['config_json'] ?? '{}', true);

        switch($this->provider) {
            case 'ollama':
                return new OllamaService($this->model, $endpoint, $extraConfig);
            case 'anthropic':
                return new ClaudeService($this->model, $apiKey, $extraConfig);
            case 'openai':
                return new OpenAiService($this->model, $apiKey, $extraConfig);
            case 'custom':
                return new CustomService($this->model, $endpoint, $apiKey, $extraConfig);
            default:
                return new OllamaService($this->model, $endpoint, $extraConfig);
        }
    }

    /**
     * Verifica si el servicio está disponible
     */
    public function verificarDisponibilidad()
    {
        $service = $this->crearService();

        if (!$service) {
            return ['disponible' => false, 'mensaje' => 'Provider no configurado'];
        }

        return $service->healthCheck();
    }
}