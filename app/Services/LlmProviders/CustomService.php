<?php
/**
 * CustomService - Implementación para APIs personalizadas
 * Permite conectar a cualquier servicio API compatible (OpenAI-like, Ollama-like)
 */
require_once __DIR__ . '/LlmProviderInterface.php';

class CustomService implements LlmProviderInterface
{
    private $model;
    private $endpoint;
    private $apiKey;
    private $config;

    public function __construct($model = 'custom', $endpoint = '', $apiKey = '', $config = [])
    {
        $this->model = $model;
        $this->endpoint = rtrim($endpoint, '/');
        $this->apiKey = $apiKey;
        $this->config = $config;
    }

    /**
     * Envía mensaje a la API personalizada
     */
    public function chat($mensaje, $historial = [])
    {
        if (empty($this->endpoint)) {
            return "Error: Endpoint no configurado";
        }

        // Construir messages para contexto
        $messages = [];

        foreach ($historial as $msg) {
            $messages[] = [
                'role' => $msg['rol'],
                'content' => $msg['mensaje']
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $mensaje
        ];

        $temperature = $this->config['temperature'] ?? 0.7;
        $maxTokens = $this->config['max_tokens'] ?? 500;

        // Formato compatible con Ollama/OpenAI
        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'stream' => false
        ];

        // Agregar opciones si el endpoint las soporta (estilo Ollama)
        if (!empty($this->config['options'])) {
            $data['options'] = [
                'temperature' => $temperature,
                'num_predict' => $maxTokens
            ];
        }

        $headers = ['Content-Type: application/json'];

        // Agregar API key si se proporcionó
        if (!empty($this->apiKey)) {
            $headers[] = 'Authorization: Bearer ' . $this->apiKey;
        }

        $ch = curl_init($this->endpoint . '/api/chat');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Error de conexión: " . $error;
        }

        if ($httpCode !== 200) {
            // Intentar con formato OpenAI
            return $this->tryOpenAiFormat($mensaje, $historial);
        }

        $result = json_decode($response, true);

        // Intentar formato Ollama
        if (isset($result['message']['content'])) {
            return trim($result['message']['content']);
        }

        // Intentar formato OpenAI
        if (isset($result['choices'][0]['message']['content'])) {
            return trim($result['choices'][0]['message']['content']);
        }

        return "Error: Respuesta inesperada";
    }

    /**
     * Intenta formato OpenAI como fallback
     */
    private function tryOpenAiFormat($mensaje, $historial)
    {
        $messages = [];
        foreach ($historial as $msg) {
            $messages[] = [
                'role' => $msg['rol'],
                'content' => $msg['mensaje']
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $mensaje];

        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => $this->config['temperature'] ?? 0.7,
            'max_tokens' => $this->config['max_tokens'] ?? 500
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . ($this->apiKey ?: 'dummy')
        ];

        // Intentar con /v1/chat/completions
        $ch = curl_init(str_replace('/api/chat', '/v1/chat/completions', $this->endpoint));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['choices'][0]['message']['content'])) {
                return trim($result['choices'][0]['message']['content']);
            }
        }

        return "Error HTTP: " . $httpCode . " - " . $response;
    }

    /**
     * Verifica disponibilidad del servicio
     */
    public function healthCheck()
    {
        if (empty($this->endpoint)) {
            return [
                'disponible' => false,
                'mensaje' => 'Endpoint no configurado'
            ];
        }

        // Probar conexión
        $ch = curl_init($this->endpoint . '/api/tags');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return [
                'disponible' => true,
                'mensaje' => 'API personalizada conectada',
                'endpoint' => $this->endpoint
            ];
        }

        // Intentar con health endpoint
        $ch = curl_init($this->endpoint . '/health');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return [
                'disponible' => true,
                'mensaje' => 'API personalizada conectada',
                'endpoint' => $this->endpoint
            ];
        }

        return [
            'disponible' => false,
            'mensaje' => 'No se pudo conectar al endpoint: ' . $this->endpoint
        ];
    }

    /**
     * Lista modelos disponibles (si el endpoint lo soporta)
     */
    public function listModels()
    {
        // Intentar obtener lista de Ollama
        $ch = curl_init($this->endpoint . '/api/tags');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['models']) && is_array($result['models'])) {
            return array_map(function($m) {
                return $m['name'];
            }, $result['models']);
        }

        return [$this->model];
    }
}