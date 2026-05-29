<?php
/**
 * OllamaService - Implementación para Ollama local
 * Conecta a Ollama corriendo en localhost:11434
 */
require_once __DIR__ . '/LlmProviderInterface.php';

class OllamaService implements LlmProviderInterface
{
    private $model;
    private $endpoint;
    private $config;

    public function __construct($model = 'llama3', $endpoint = 'http://localhost:11434', $config = [])
    {
        $this->model = $model;
        $this->endpoint = rtrim($endpoint, '/');
        $this->config = $config;
    }

    /**
     * Envía mensaje a Ollama
     */
    public function chat($mensaje, $historial = [])
    {
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

        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'stream' => false,
            'options' => [
                'temperature' => $temperature,
                'num_predict' => $maxTokens
            ]
        ];

        $ch = curl_init($this->endpoint . '/api/chat');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Error de conexión: " . $error;
        }

        if ($httpCode !== 200) {
            return "Error HTTP: " . $httpCode . " - " . $response;
        }

        $result = json_decode($response, true);

        if (isset($result['message']['content'])) {
            return trim($result['message']['content']);
        }

        return "Error: Respuesta inesperada de Ollama";
    }

    /**
     * Verifica disponibilidad de Ollama
     */
    public function healthCheck()
    {
        $ch = curl_init($this->endpoint . '/api/tags');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return [
                'disponible' => true,
                'mensaje' => 'Ollama está funcionando',
                'modelos' => $this->listModels()
            ];
        }

        return [
            'disponible' => false,
            'mensaje' => 'Ollama no está disponible. Asegúrate de que esté corriendo en ' . $this->endpoint
        ];
    }

    /**
     * Lista modelos disponibles en Ollama
     */
    public function listModels()
    {
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

        return [];
    }
}