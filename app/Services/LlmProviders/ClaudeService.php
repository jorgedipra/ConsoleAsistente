<?php
/**
 * ClaudeService - Implementación para Claude (Anthropic API)
 */
require_once __DIR__ . '/LlmProviderInterface.php';

class ClaudeService implements LlmProviderInterface
{
    private $model;
    private $apiKey;
    private $config;
    private $baseUrl = 'https://api.anthropic.com/v1';

    public function __construct($model = 'claude-3-haiku-20240307', $apiKey = '', $config = [])
    {
        $this->model = $model;
        $this->apiKey = $apiKey;
        $this->config = $config;
    }

    /**
     * Envía mensaje a Claude
     */
    public function chat($mensaje, $historial = [])
    {
        if (empty($this->apiKey)) {
            return "Error: API Key de Anthropic no configurada";
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

        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature
        ];

        $ch = curl_init($this->baseUrl . '/messages');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-api-key: ' . $this->apiKey,
            'anthropic-version: 2023-06-01',
            'anthropic-dangerous-direct-browser-access: true'
        ]);
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

        if (isset($result['content'][0]['text'])) {
            return trim($result['content'][0]['text']);
        }

        return "Error: Respuesta inesperada de Claude";
    }

    /**
     * Verifica disponibilidad de Claude API
     */
    public function healthCheck()
    {
        if (empty($this->apiKey)) {
            return [
                'disponible' => false,
                'mensaje' => 'API Key no configurada'
            ];
        }

        return [
            'disponible' => true,
            'mensaje' => 'Claude API configurada con modelo: ' . $this->model,
            'modelos' => ['claude-3-haiku', 'claude-3-sonnet', 'claude-3-opus', 'claude-3.5-sonnet']
        ];
    }

    /**
     * Lista modelos disponibles
     */
    public function listModels()
    {
        return [
            'claude-3-haiku-20240307',
            'claude-3-sonnet-20240229',
            'claude-3-opus-20240229',
            'claude-3.5-haiku-20241022',
            'claude-3.5-sonnet-20241022'
        ];
    }
}